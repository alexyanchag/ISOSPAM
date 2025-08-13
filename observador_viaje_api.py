from datetime import datetime
from typing import List, Optional

from fastapi import Depends, HTTPException, Query
from pydantic import BaseModel

# Placeholder imports: in real application, these should be imported from actual modules
# from .dependencies import Consulta2, obtener_respuestas_multifinalitarias, crear_respuesta_multifinalitaria, actualizar_respuesta_multifinalitaria

# Dummy placeholders for type hints to avoid NameError during runtime compilation
class RespuestaMultifinalitaria(BaseModel):
    id: Optional[int]
    tabla_relacionada_id: Optional[int]


def Consulta2():
    """Dummy database dependency placeholder."""
    pass


def obtener_respuestas_multifinalitarias(cursor, campania_id, tabla, relacion_id):
    return []


def crear_respuesta_multifinalitaria(respuesta, cursor, commit):
    pass


def actualizar_respuesta_multifinalitaria(respuesta_id, respuesta, cursor, commit):
    pass


class ObservadorViaje(BaseModel):
    id: Optional[int]
    viaje_id: Optional[int]
    tipo_observador_id: Optional[int]
    persona_idpersona: Optional[int]
    fechaborrado: Optional[datetime] = None
    persona_nombres: Optional[str] = None  # Nuevo campo opcional
    tipo_observador_descripcion: Optional[str] = None  # Nuevo campo opcional

    respuestas_multifinalitaria: Optional[List[RespuestaMultifinalitaria]] = []


# `isospam` would be a FastAPI instance or APIRouter in the real application
class DummyRouter:
    def get(self, *args, **kwargs):
        def decorator(func):
            return func
        return decorator

    def post(self, *args, **kwargs):
        def decorator(func):
            return func
        return decorator

    def put(self, *args, **kwargs):
        def decorator(func):
            return func
        return decorator

    def delete(self, *args, **kwargs):
        def decorator(func):
            return func
        return decorator


isospam = DummyRouter()


@isospam.get("/isospam/observadores-viaje", response_model=List[ObservadorViaje])
def listar_observadores_por_viaje(
    viaje_id: int = Query(..., description="ID del viaje"),
    cursor=Depends(Consulta2)
):
    cursor.execute("""
        SELECT ov.id, ov.viaje_id, ov.tipo_observador_id, ov.persona_idpersona, ov.fechaborrado,
               p.nombres AS persona_nombres,
               tobs.descripcion AS tipo_observador_descripcion,
               v.campania_id
        FROM observador_viaje ov
        LEFT JOIN persona p ON ov.persona_idpersona = p.idpersona
        LEFT JOIN tipo_observador tobs ON ov.tipo_observador_id = tobs.id
        JOIN viaje v ON ov.viaje_id = v.id
        WHERE ov.viaje_id = %s AND ov.fechaborrado IS NULL
    """, (viaje_id,))
    rows = cursor.fetchall()
    resultados: List[ObservadorViaje] = []
    for row in rows:
        obs = ObservadorViaje(**row)
        campania_id = row["campania_id"]
        if campania_id:
            obs.respuestas_multifinalitaria = obtener_respuestas_multifinalitarias(
                cursor, campania_id, "observador_viaje", obs.id
            )
        else:
            obs.respuestas_multifinalitaria = []
        resultados.append(obs)
    return resultados


@isospam.get("/isospam/observadores-viaje/{id}", response_model=ObservadorViaje)
def obtener_observador_viaje(id: int, cursor=Depends(Consulta2)):
    cursor.execute("""
        SELECT ov.id, ov.viaje_id, ov.tipo_observador_id, ov.persona_idpersona, ov.fechaborrado,
               p.nombres AS persona_nombres,
               tobs.descripcion AS tipo_observador_descripcion,
               v.campania_id
        FROM observador_viaje ov
        LEFT JOIN persona p ON ov.persona_idpersona = p.idpersona
        LEFT JOIN tipo_observador tobs ON ov.tipo_observador_id = tobs.id
        JOIN viaje v ON ov.viaje_id = v.id
        WHERE ov.id = %s AND ov.fechaborrado IS NULL
    """, (id,))
    row = cursor.fetchone()
    if not row:
        raise HTTPException(status_code=404, detail="Observador no encontrado.")
    obs = ObservadorViaje(**row)
    campania_id = row["campania_id"]
    if campania_id:
        obs.respuestas_multifinalitaria = obtener_respuestas_multifinalitarias(
            cursor, campania_id, "observador_viaje", obs.id
        )
    else:
        obs.respuestas_multifinalitaria = []
    return obs


@isospam.post("/isospam/observadores-viaje", response_model=ObservadorViaje)
def crear_observador_viaje(observador: ObservadorViaje, cursor=Depends(Consulta2), commit: bool = Depends(lambda: True)):
    try:
        cursor.execute("""
            INSERT INTO observador_viaje (
                viaje_id, tipo_observador_id, persona_idpersona
            )
            VALUES (%s, %s, %s)
            RETURNING id
        """, (
            observador.viaje_id,
            observador.tipo_observador_id,
            observador.persona_idpersona
        ))
        observador.id = cursor.fetchone()["id"]

        # Si se requiere, se pueden insertar respuestas multifinalitarias aquí
        for respuesta in observador.respuestas_multifinalitaria:
            respuesta.tabla_relacionada_id = observador.id
            crear_respuesta_multifinalitaria(
                respuesta,
                cursor,
                False
            )

        if commit:
            cursor.connection.commit()
    except Exception as e:
        cursor.connection.rollback()
        raise HTTPException(status_code=500, detail=f"Error al insertar: {str(e)}")
    return observador


@isospam.put("/isospam/observadores-viaje/{id}", response_model=ObservadorViaje)
def actualizar_observador_viaje(id: int, observador: ObservadorViaje, cursor=Depends(Consulta2)):
    cursor.execute("SELECT * FROM observador_viaje WHERE id = %s AND fechaborrado IS NULL", (id,))
    if cursor.fetchone() is None:
        raise HTTPException(status_code=404, detail="Observador no encontrado.")

    try:
        cursor.execute("""
            UPDATE observador_viaje
            SET viaje_id = %s,
                tipo_observador_id = %s,
                persona_idpersona = %s
            WHERE id = %s
        """, (
            observador.viaje_id,
            observador.tipo_observador_id,
            observador.persona_idpersona,
            id
        ))
        
        # Si se requiere, se pueden insertar respuestas multifinalitarias aquí
        for respuesta in observador.respuestas_multifinalitaria:
            if respuesta.id is None:
                respuesta.tabla_relacionada_id = id
                crear_respuesta_multifinalitaria(
                    respuesta,
                    cursor,
                    False
                )
            else:
                actualizar_respuesta_multifinalitaria(
                    respuesta.id,
                    respuesta,
                    cursor,
                    False
                )

        cursor.connection.commit()
    except Exception as e:
        cursor.connection.rollback()
        raise HTTPException(status_code=500, detail=f"Error al actualizar: {str(e)}")
    observador.id = id
    return observador


@isospam.delete("/isospam/observadores-viaje/{id}")
def borrar_observador_viaje(id: int, cursor=Depends(Consulta2)):
    cursor.execute("SELECT * FROM observador_viaje WHERE id = %s AND fechaborrado IS NULL", (id,))
    if cursor.fetchone() is None:
        raise HTTPException(status_code=404, detail="Observador no encontrado o ya eliminado.")

    try:
        cursor.execute("""
            UPDATE observador_viaje
            SET fechaborrado = %s
            WHERE id = %s
        """, (datetime.now(), id))
        cursor.connection.commit()
    except Exception as e:
        cursor.connection.rollback()
        raise HTTPException(status_code=500, detail=f"Error al eliminar: {str(e)}")

    return {"mensaje": f"Observador con id {id} fue eliminado correctamente."}
