from datetime import datetime
from typing import List, Optional

from fastapi import Depends, HTTPException, Query
from pydantic import BaseModel

from observador_viaje_api import (
    RespuestaMultifinalitaria,
    Consulta2,
    obtener_respuestas_multifinalitarias,
    crear_respuesta_multifinalitaria,
    actualizar_respuesta_multifinalitaria,
    isospam,
)


class TripulanteViaje(BaseModel):
    id: Optional[int]
    viaje_id: int
    tipo_tripulante_id: Optional[int]
    persona_idpersona: Optional[int]
    tipo_tripulante_nombre: Optional[str] = None
    tripulante_nombres: Optional[str] = None
    fechaborrado: Optional[datetime] = None

    respuestas_multifinalitaria: Optional[List[RespuestaMultifinalitaria]] = []


@isospam.get("/isospam/tripulantes-viaje", response_model=List[TripulanteViaje])
def listar_tripulantes_viaje(
    viaje_id: int = Query(..., description="ID del viaje"),
    cursor=Depends(Consulta2)
):
    cursor.execute(
        """
        SELECT tv.id, tv.viaje_id, tv.tipo_tripulante_id, tv.persona_idpersona, tv.fechaborrado,
               tt.descripcion AS tipo_tripulante_nombre,
               p.nombres || ' ' || p.apellidos AS tripulante_nombres,
               v.campania_id
        FROM tripulante_viaje tv
        LEFT JOIN tipo_tripulante tt ON tt.id = tv.tipo_tripulante_id
        LEFT JOIN persona p ON p.idpersona = tv.persona_idpersona
        JOIN viaje v ON tv.viaje_id = v.id
        WHERE tv.viaje_id = %s AND tv.fechaborrado IS NULL
    """,
        (viaje_id,),
    )
    rows = cursor.fetchall()
    resultados: List[TripulanteViaje] = []
    for row in rows:
        trip = TripulanteViaje(**row)
        campania_id = row["campania_id"]
        if campania_id:
            trip.respuestas_multifinalitaria = obtener_respuestas_multifinalitarias(
                cursor, campania_id, "tripulante_viaje", trip.id
            )
        else:
            trip.respuestas_multifinalitaria = []
        resultados.append(trip)
    return resultados


@isospam.get("/isospam/tripulantes-viaje/{id}", response_model=TripulanteViaje)
def obtener_tripulante_viaje(id: int, cursor=Depends(Consulta2)):
    cursor.execute(
        """
        SELECT tv.id, tv.viaje_id, tv.tipo_tripulante_id, tv.persona_idpersona, tv.fechaborrado,
               tt.descripcion AS tipo_tripulante_nombre,
               p.nombres || ' ' || p.apellidos AS tripulante_nombres,
               v.campania_id
        FROM tripulante_viaje tv
        LEFT JOIN tipo_tripulante tt ON tt.id = tv.tipo_tripulante_id
        LEFT JOIN persona p ON p.idpersona = tv.persona_idpersona
        JOIN viaje v ON tv.viaje_id = v.id
        WHERE tv.id = %s AND tv.fechaborrado IS NULL
    """,
        (id,),
    )
    row = cursor.fetchone()
    if not row:
        raise HTTPException(status_code=404, detail="Tripulante no encontrado")
    trip = TripulanteViaje(**row)
    campania_id = row["campania_id"]
    if campania_id:
        trip.respuestas_multifinalitaria = obtener_respuestas_multifinalitarias(
            cursor, campania_id, "tripulante_viaje", trip.id
        )
    else:
        trip.respuestas_multifinalitaria = []
    return trip


@isospam.post("/isospam/tripulantes-viaje", response_model=TripulanteViaje)
def crear_tripulante_viaje(
    tripulante: TripulanteViaje,
    cursor=Depends(Consulta2),
    commit: bool = Depends(lambda: True),
):
    cursor.execute(
        """
        INSERT INTO tripulante_viaje (viaje_id, tipo_tripulante_id, persona_idpersona)
        VALUES (%s, %s, %s)
        RETURNING id
    """,
        (tripulante.viaje_id, tripulante.tipo_tripulante_id, tripulante.persona_idpersona),
    )
    tripulante.id = cursor.fetchone()["id"]

    for respuesta in tripulante.respuestas_multifinalitaria:
        respuesta.tabla_relacionada_id = tripulante.id
        crear_respuesta_multifinalitaria(
            respuesta,
            cursor,
            False,
        )

    if commit:
        cursor.connection.commit()
    return tripulante


@isospam.put("/isospam/tripulantes-viaje/{id}", response_model=TripulanteViaje)
def actualizar_tripulante_viaje(
    id: int, tripulante: TripulanteViaje, cursor=Depends(Consulta2)
):
    cursor.execute(
        "SELECT * FROM tripulante_viaje WHERE id = %s AND fechaborrado IS NULL",
        (id,),
    )
    if cursor.fetchone() is None:
        raise HTTPException(status_code=404, detail="Tripulante no encontrado.")

    cursor.execute(
        """
        UPDATE tripulante_viaje
        SET viaje_id = %s,
            tipo_tripulante_id = %s,
            persona_idpersona = %s
        WHERE id = %s
    """,
        (
            tripulante.viaje_id,
            tripulante.tipo_tripulante_id,
            tripulante.persona_idpersona,
            id,
        ),
    )

    for respuesta in tripulante.respuestas_multifinalitaria:
        if respuesta.id is None:
            respuesta.tabla_relacionada_id = id
            crear_respuesta_multifinalitaria(
                respuesta,
                cursor,
                False,
            )
        else:
            actualizar_respuesta_multifinalitaria(
                respuesta.id,
                respuesta,
                cursor,
                False,
            )

    cursor.connection.commit()
    tripulante.id = id
    return tripulante


@isospam.delete("/isospam/tripulantes-viaje/{id}")
def eliminar_tripulante_viaje(id: int, cursor=Depends(Consulta2)):
    now = datetime.now()
    cursor.execute(
        """
        UPDATE tripulante_viaje
        SET fechaborrado = %s
        WHERE id = %s AND fechaborrado IS NULL
    """,
        (now, id),
    )
    cursor.connection.commit()
    return {"mensaje": "Tripulante marcado como eliminado"}
