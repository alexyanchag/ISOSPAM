from datetime import datetime, time
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


class ParametrosAmbientales(BaseModel):
    id: Optional[int]
    viaje_id: int
    hora: Optional[time]
    sondeo_ppt: Optional[float]
    tsmp: Optional[float]
    estado_marea_id: Optional[int]
    condicion_mar_id: Optional[int]
    oxigeno_mg_l: Optional[float]
    fechaborrado: Optional[datetime] = None
    estado_marea_descripcion: Optional[str] = None
    condicion_mar_descripcion: Optional[str] = None

    respuestas_multifinalitaria: Optional[List[RespuestaMultifinalitaria]] = []


@isospam.get("/isospam/parametros-ambientales", response_model=List[ParametrosAmbientales])
def listar_parametros_por_viaje(
    viaje_id: int = Query(..., description="ID del viaje"),
    cursor=Depends(Consulta2),
):
    cursor.execute(
        """
        SELECT pa.id, pa.viaje_id, pa.hora, pa.sondeo_ppt, pa.tsmp,
               pa.estado_marea_id, pa.condicion_mar_id, pa.oxigeno_mg_l, pa.fechaborrado,
               em.descripcion AS estado_marea_descripcion,
               cm.descripcion AS condicion_mar_descripcion,
               v.campania_id
        FROM parametros_ambientales pa
        LEFT JOIN estado_marea em ON pa.estado_marea_id = em.id
        LEFT JOIN condicion_mar cm ON pa.condicion_mar_id = cm.id
        JOIN viaje v ON pa.viaje_id = v.id
        WHERE pa.viaje_id = %s AND pa.fechaborrado IS NULL
    """,
        (viaje_id,),
    )
    rows = cursor.fetchall()
    resultados: List[ParametrosAmbientales] = []
    for row in rows:
        param = ParametrosAmbientales(**row)
        campania_id = row["campania_id"]
        if campania_id:
            param.respuestas_multifinalitaria = obtener_respuestas_multifinalitarias(
                cursor, campania_id, "parametros_ambientales", param.id
            )
        else:
            param.respuestas_multifinalitaria = []
        resultados.append(param)
    return resultados


@isospam.get("/isospam/parametros-ambientales/{id}", response_model=ParametrosAmbientales)
def obtener_parametros(id: int, cursor=Depends(Consulta2)):
    cursor.execute(
        """
        SELECT pa.id, pa.viaje_id, pa.hora, pa.sondeo_ppt, pa.tsmp,
               pa.estado_marea_id, pa.condicion_mar_id, pa.oxigeno_mg_l, pa.fechaborrado,
               em.descripcion AS estado_marea_descripcion,
               cm.descripcion AS condicion_mar_descripcion,
               v.campania_id
        FROM parametros_ambientales pa
        LEFT JOIN estado_marea em ON pa.estado_marea_id = em.id
        LEFT JOIN condicion_mar cm ON pa.condicion_mar_id = cm.id
        JOIN viaje v ON pa.viaje_id = v.id
        WHERE pa.id = %s AND pa.fechaborrado IS NULL
    """,
        (id,),
    )
    row = cursor.fetchone()
    if not row:
        raise HTTPException(status_code=404, detail="Parámetro no encontrado.")
    param = ParametrosAmbientales(**row)
    campania_id = row["campania_id"]
    if campania_id:
        param.respuestas_multifinalitaria = obtener_respuestas_multifinalitarias(
            cursor, campania_id, "parametros_ambientales", param.id
        )
    else:
        param.respuestas_multifinalitaria = []
    return param


@isospam.post("/isospam/parametros-ambientales", response_model=ParametrosAmbientales)
def crear_parametros(
    param: ParametrosAmbientales, cursor=Depends(Consulta2), commit: bool = Depends(lambda: True)
):
    cursor.execute(
        """
        INSERT INTO parametros_ambientales (
            viaje_id, hora, sondeo_ppt, tsmp,
            estado_marea_id, condicion_mar_id, oxigeno_mg_l
        ) VALUES (%s, %s, %s, %s, %s, %s, %s)
        RETURNING id
    """,
        (
            param.viaje_id,
            param.hora,
            param.sondeo_ppt,
            param.tsmp,
            param.estado_marea_id,
            param.condicion_mar_id,
            param.oxigeno_mg_l,
        ),
    )
    param.id = cursor.fetchone()["id"]

    for respuesta in param.respuestas_multifinalitaria:
        respuesta.tabla_relacionada_id = param.id
        crear_respuesta_multifinalitaria(
            respuesta,
            cursor,
            False,
        )

    if commit:
        cursor.connection.commit()
    return param


@isospam.put("/isospam/parametros-ambientales/{id}", response_model=ParametrosAmbientales)
def actualizar_parametros(id: int, param: ParametrosAmbientales, cursor=Depends(Consulta2)):
    cursor.execute(
        "SELECT id FROM parametros_ambientales WHERE id = %s AND fechaborrado IS NULL",
        (id,),
    )
    if not cursor.fetchone():
        raise HTTPException(status_code=404, detail="Parámetro no encontrado.")

    cursor.execute(
        """
        UPDATE parametros_ambientales SET
            viaje_id = %s,
            hora = %s,
            sondeo_ppt = %s,
            tsmp = %s,
            estado_marea_id = %s,
            condicion_mar_id = %s,
            oxigeno_mg_l = %s
        WHERE id = %s
    """,
        (
            param.viaje_id,
            param.hora,
            param.sondeo_ppt,
            param.tsmp,
            param.estado_marea_id,
            param.condicion_mar_id,
            param.oxigeno_mg_l,
            id,
        ),
    )

    for respuesta in param.respuestas_multifinalitaria:
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
    param.id = id
    return param


@isospam.delete("/isospam/parametros-ambientales/{id}")
def eliminar_parametros(id: int, cursor=Depends(Consulta2)):
    cursor.execute(
        "SELECT id FROM parametros_ambientales WHERE id = %s AND fechaborrado IS NULL",
        (id,),
    )
    if not cursor.fetchone():
        raise HTTPException(status_code=404, detail="Parámetro no encontrado o ya eliminado.")

    cursor.execute(
        """
        UPDATE parametros_ambientales
        SET fechaborrado = NOW()
        WHERE id = %s
    """,
        (id,),
    )
    cursor.connection.commit()
    return {"mensaje": f"Parámetro con id {id} eliminado correctamente (borrado lógico)."}

