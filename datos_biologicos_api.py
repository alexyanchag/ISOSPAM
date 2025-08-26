from typing import List, Optional
from pydantic import BaseModel
from fastapi import Depends, Query
from datetime import datetime

# Dummy placeholders for type hints to avoid NameError during runtime compilation
def Consulta2():
    """Dummy database dependency placeholder."""
    pass

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

class DatoBiologico(BaseModel):
    id: Optional[int]
    captura_id: Optional[int]
    unidad_longitud_id: Optional[int]
    longitud: Optional[float]
    peso: Optional[float]
    sexo: Optional[str]
    ovada: Optional[bool]
    estado_desarrollo_gonadal_id: Optional[int]
    fechaborrado: Optional[datetime] = None

@isospam.get("/isospam/datos-biologicos", response_model=List[DatoBiologico])
def listar_datos_biologicos(
    captura_id: int = Query(..., description="ID de la captura"),
    cursor=Depends(Consulta2)
):
    return []

@isospam.get("/isospam/datos-biologicos/{id}", response_model=DatoBiologico)
def obtener_dato_biologico(id: int, cursor=Depends(Consulta2)):
    return DatoBiologico(id=id)

@isospam.post("/isospam/datos-biologicos", response_model=DatoBiologico)
def crear_dato_biologico(dato: DatoBiologico, cursor=Depends(Consulta2), commit: bool = Depends(lambda: True)):
    dato.id = 1
    return dato

@isospam.put("/isospam/datos-biologicos/{id}", response_model=DatoBiologico)
def actualizar_dato_biologico(id: int, dato: DatoBiologico, cursor=Depends(Consulta2)):
    dato.id = id
    return dato

@isospam.delete("/isospam/datos-biologicos/{id}")
def eliminar_dato_biologico(id: int, cursor=Depends(Consulta2)):
    return {"message": "deleted"}

