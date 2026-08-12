# Cotizacion por modulos - Migracion a Spring Boot + Vue

Fecha: 2026-02-08

## Supuestos base
- Equipo: 1 desarrollador FullStack.
- Jornada: 40 h/semana por dev (40 h/semana de equipo).
- Arquitectura: monolito modular con APIs por dominio.
- PDFs: mismos formatos del sistema actual.
- Migracion de datos: una sola ventana de carga (sin sincronizacion continua).
- Integraciones nuevas: fuera de alcance.
- Objetivo inmediato: MVP, despues iteraciones.
- Tarifa: 150 MXN por hora por desarrollador.

## Como se calcula el costo
- `Horas equipo = semanas * 40`.
- `Costo modulo = Horas equipo * 150`.

## Cotizacion por modulo (alcance completo)

| Modulo | Alcance principal | Dependencias | Tiempo (semanas) | Horas (1 dev) | Costo (MXN) |
| --- | --- | --- | --- | --- | --- |
| Base plataforma | Proyecto Spring Boot + Vue; auth; roles; usuarios; perfil; layout base; navegacion; logging | Ninguna | 2 a 3 | 80 a 120 | 12,000 a 18,000 |
| Catalogos + config | Catalogo de gases; datos empresa; configuraciones base para PDFs | Base | 1 a 1 | 40 a 40 | 6,000 a 6,000 |
| Clientes | CRUD clientes con y sin contrato; validaciones; busquedas; detalle | Base | 2 a 3 | 80 a 120 | 12,000 a 18,000 |
| Contratos + asignaciones | CRUD contratos; asignaciones cilindros; notas de asignacion; agreement; PDFs contrato/anexos | Clientes, catalogos | 3 a 4 | 120 a 160 | 18,000 a 24,000 |
| Tanques | CRUD; estados; reportados; historial por cilindro; validacion PH; listados por estatus | Catalogos | 3 a 4 | 120 a 160 | 18,000 a 24,000 |
| Notas contrato | Salida/entrada; pagos parciales; listados/adeudos; cancelaciones; PDFs | Contratos, tanques | 4 a 5 | 160 a 200 | 24,000 a 30,000 |
| Nota exporadica | Mostrador; entradas/salidas; estatus; cancelaciones; PDF | Clientes sin contrato, tanques | 1 a 2 | 40 a 80 | 6,000 a 12,000 |
| Nota foranea | Salida/entrada; cambios de estatus; cancelaciones; PDF | Clientes sin contrato, tanques | 1 a 2 | 40 a 80 | 6,000 a 12,000 |
| Nota talon | Entradas/salidas; pendientes; cancelaciones; PDF | Clientes sin contrato, tanques | 1 a 2 | 40 a 80 | 6,000 a 12,000 |
| Nota reserva | Entrada/salida; historial; PDF | Drivers, cars, tanques | 1 a 2 | 40 a 80 | 6,000 a 12,000 |
| Infra | Entrada/salida; pendientes; control de diferencias; PDF | Tanques | 1 a 2 | 40 a 80 | 6,000 a 12,000 |
| Mantenimiento | Entrada/salida; pendientes; actualizacion PH; PDF | Tanques | 1 a 2 | 40 a 80 | 6,000 a 12,000 |
| Transporte | CRUD transporte; filtros; bitacora; PDF | Drivers, cars | 2 a 3 | 80 a 120 | 12,000 a 18,000 |
| Cars + drivers | CRUD autos/choferes; validaciones | Base | 1 a 1 | 40 a 40 | 6,000 a 6,000 |
| Concentrators CRUD | Alta/edicion/consulta; estado; busqueda por serie | Base | 1 a 2 | 40 a 80 | 6,000 a 12,000 |
| Concentrators notas/pagos | Renta; pagos; devolucion; cierre; PDF | Concentrators, clientes sin contrato | 2 a 3 | 80 a 120 | 12,000 a 18,000 |
| Concentrators mantenimiento | Registro; devolucion; control de estatus | Concentrators | 1 a 2 | 40 a 80 | 6,000 a 12,000 |
| Migracion de datos | ETL; mapeo; validacion; limpieza minima; carga unica | Base | 2 a 4 | 80 a 160 | 12,000 a 24,000 |
| QA y hardening | Pruebas funcionales; regresion; ajustes; estabilizacion | Todos | 2 a 4 | 80 a 160 | 12,000 a 24,000 |

**Total estimado (alcance completo)**
- Tiempo: 32 a 51 semanas
- Horas equipo: 1280 a 2040
- Costo: 192,000 a 306,000
- Buffer 15%: 220,800 a 351,900
- Tiempo con buffer 15%: 37 a 59 semanas

## Alcance detallado por modulo (resumen)

**Diseno BD**  
Redisenio de modelo entidad-relacion, definicion de esquema y tablas, indices basicos, mapeo inicial a entidades.

**Base plataforma**  
Proyecto Spring Boot + Vue, auth, roles, usuarios, perfil, layout base, configuracion inicial y navegacion.

**Config. generales sistema**  
Datos de empresa y parametros necesarios para PDFs y configuraciones base.

**Clientes**  
CRUD clientes con contrato y sin contrato, validaciones, busquedas y vistas de detalle.

**Tanques**  
CRUD tanques, estados, reportados, historial por cilindro, validacion PH, listados por estatus.

**Concentrators**  
CRUD concentradores, gestion de estado, consultas por serie.

**Contratos + asignaciones**  
CRUD contratos, asignaciones de cilindros, notas de asignacion, PDF de contrato y anexos.

**Notas**  
Notas de contrato (salida/entrada/pagos/listados), notas exporadica, foranea, talon y reserva, cancelaciones, PDFs de notas.

**Infra**  
Entrada/salida, pendientes, control de diferencias, PDF.

**Mantenimiento**  
Entrada/salida, pendientes, actualizacion de PH, PDF.

**Transporte**  
Bitacora con filtros, CRUD transporte, PDF de bitacora.

**Cars + drivers**  
Catalogos de autos y choferes con CRUD y validaciones.

**Concentradores mantenimiento**  
Registro de mantenimiento, devolucion y control de estatus.

**Migracion de datos**  
ETL, mapeo, validacion, limpieza minima, carga en una sola ventana.

**QA y hardening**  
Pruebas funcionales, regresion, ajustes y estabilizacion.

## MVP propuesto (salir antes)

**Objetivo MVP**
- Operar clientes, contratos, tanques y notas contrato con PDFs esenciales.
- Tener seguridad y roles funcionales.
- Migrar datos clave en una sola ventana.

**Modulos incluidos en MVP**
- Base plataforma.
- Catalogos + config empresa.
- Clientes (con y sin contrato si se requiere para notas).
- Contratos + asignaciones + PDF contrato.
- Tanques (CRUD + estados basicos + validacion PH).
- Notas contrato (salida, entrada, pagos, listados, PDF nota).
- Notas exporadica, foranea, talon, reserva.
- Migracion de datos (clientes, contratos, asignaciones, tanques, usuarios, notas activas si aplica).
- QA y hardening.

**Tiempo MVP**
- 16 a 26 semanas (640 a 1040 horas de equipo).
- Costo MVP: 96,000 a 156,000.
- Buffer 15% MVP: 110,400 a 179,400.
- Tiempo MVP con buffer 15%: 19 a 30 semanas.

## MVP con entregables (secuencial con solapes puntuales)

**Entrega 1: Base y cimientos (2 a 3 semanas)**
- Proyecto base Spring Boot + Vue.
- Auth, roles, usuarios, perfil.
- Layout base y navegacion.
- Configuracion de catalogos iniciales.

**Entrega 2: Clientes + contratos (4 a 6 semanas)**
- Clientes con y sin contrato.
- Contratos + asignaciones.
- PDF de contrato.

**Entrega 3: Tanques + notas de contrato (5 a 7 semanas)**
- Tanques (CRUD, estados, historial, reportados).
- Notas contrato salida/entrada.
- Pagos y listados.
- PDF nota contrato.

**Entrega 4: Notas exporadica/foranea/talon/reserva (4 a 6 semanas)**
- Flujos completos con PDFs.
- Validaciones y cambios de estatus.

**Entrega 5: Migracion + QA (2 a 4 semanas)**
- Carga historica en una ventana.
- Validaciones y pruebas de regresion.

Nota: las entregas pueden solaparse parcialmente para acortar calendario.

## Iteraciones posteriores (post-MVP)

**Fase 2**
- Infra y mantenimiento.
- Transporte + bitacora + PDF.

**Fase 3**
- Concentrators CRUD.
- Concentrators notas/pagos + PDFs.
- Concentrators mantenimiento.

## Riesgos y buffer sugerido
- Reglas de negocio no documentadas.
- Calidad de datos historicos.
- Ajustes en PDFs para igualar formato actual.
- Se incluye un buffer del 15% en tiempo y costo.

## Siguientes pasos para cerrar la cotizacion
- Confirmar alcance exacto del MVP.
- Listar los PDFs exactos a replicar en el MVP.
- Definir el subset de datos historicos a migrar en la primera ventana.
