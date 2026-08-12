# Documentacion tecnica para migracion a Spring Boot + Vue

Fecha de analisis: 2026-02-08

## Alcance y fuentes
Este documento se genero a partir de:
- `routes/web.php`
- Controladores en `app/Http/Controllers`
- Modelos en `app/Models` y `app/User.php`, `app/Role.php`, `app/Permissions.php`
- Migraciones en `database/migrations`
- Vistas en `resources/views`

`Documentacion.md` estaba vacio, asi que el contenido es un analisis estatico del codigo. No reemplaza la validacion con usuarios finales.

## Resumen de arquitectura actual
- Backend: Laravel 7.30.4 con PHP 7.4.33.
- UI: Blade server-side + DataTables (Yajra).
- PDF: DomPDF (Barryvdh).
- Autenticacion: `Auth::routes()` + roles y permisos propios.
- Rutas: principalmente web, sin API publica en `routes/api.php`.

## Inventario de tablas (migraciones)
- `users`, `password_resets`, `failed_jobs`
- `permissions`, `roles`, `role_user`, `permissions_role`
- `clientes`, `clientes_sin_contrato`
- `catalogo_gases`
- `tanques`, `tanques_reportados`
- `contratos`
- `asignacion`, `nota_asignacion`, `detalle_nota_asignacion`
- `notas`, `nota_tanque`, `nota_pagos`
- `notas_entrada`, `notas_entrada_tanque`
- `ventas`, `venta_tanque`
- `nota_foranea`, `notaforanea_tanque`
- `nota_talon`, `nota_talontanque`
- `nota_reserva`, `nota_reserva_tanque`
- `infra_llenado`, `infra_tanques`
- `mantenimiento_llenado`, `mantenimiento_tanques`
- `cars`, `drivers`
- `transportes`, `transporte_bitacoras`
- `config_sistem`, `datos_empresa`
- `agreements`
- `concentrators`, `concentrator_notas`, `concentrator_payments`, `concentrator_maintenances`

## Mapa de modulos (matriz de pantallas, controladores y tablas)

| Modulo | Controladores | Vistas (carpeta) | Tablas principales | Rutas base |
| --- | --- | --- | --- | --- |
| Autenticacion | `Auth/*` | `resources/views/auth` | `users`, `password_resets` | `/`, `/home`, `Auth::routes()` |
| Usuarios y roles | `UserController`, `RoleController` | `resources/views/usuarios`, `resources/views/roles` | `users`, `roles`, `role_user`, `permissions`, `permissions_role` | `/user/*`, `/rol/*` |
| Perfil | `PerfilController` | `resources/views/perfil` | `users`, `role_user` | `/perfil/*` |
| Configuracion empresa | `ConfigSystemController` | `resources/views/config_system` | `datos_empresa`, `config_sistem` | `/config/empresa/*` |
| Clientes | `ClienteController` | `resources/views/clientes` | `clientes` | `/cliente/*`, `/client/*` |
| Clientes sin contrato | `ClienteSinContratoController` | `resources/views/clientes_sc` | `clientes_sin_contrato` | `/clientes_sc/*` |
| Contratos | `ContratoController`, `AgreementController` | `resources/views/contratos`, `resources/views/agreement` | `contratos`, `asignacion`, `nota_asignacion`, `detalle_nota_asignacion` | `/contrato/*`, `/agreement/*` |
| Asignaciones | `AsignacionController` | `resources/views/contratos`, `resources/views/notas` | `asignacion`, `nota_asignacion`, `detalle_nota_asignacion` | `/asignaciones/*` |
| Notas contrato | `NotaController`, `NotaListasController`, `NotaPagosController` | `resources/views/notas/contrato`, `resources/views/notas/pagos` | `notas`, `nota_tanque`, `notas_entrada`, `notas_entrada_tanque`, `nota_pagos` | `/nota/contrato/*`, `/nota/pagos/*` |
| Notas exporadicas | `NotaExporadicaController` | `resources/views/notas/mostrador` | `ventas`, `venta_tanque`, `clientes_sin_contrato` | `/nota/exporadica/*` |
| Notas foraneas | `NotaForaneaController` | `resources/views/notas/foranea` | `nota_foranea`, `notaforanea_tanque` | `/nota/foranea/*` |
| Notas talon | `NotaTalonController` | `resources/views/notas/talon` | `nota_talon`, `nota_talontanque` | `/nota/talon/*` |
| Notas reserva | `NotaReservaController` | `resources/views/notas/reserva` | `nota_reserva`, `nota_reserva_tanque` | `/nota/reserva/*` |
| Tanques | `TanqueController` | `resources/views/tanques` | `tanques`, `tanques_reportados` | `/tanque/*` |
| Catalogo de gases | `CatalogoGasController` | `resources/views/gas` | `catalogo_gases` | `/gas/*`, `/catalogo_gases` |
| Infra | `InfraController` | `resources/views/infra` | `infra_llenado`, `infra_tanques` | `/infra/*` |
| Mantenimiento | `MantenimientoController` | `resources/views/mantenimiento` | `mantenimiento_llenado`, `mantenimiento_tanques` | `/mantenimiento/*` |
| Transporte | `TransporteController`, `TransporteBitacoraController` | `resources/views/transporte` | `transportes`, `transporte_bitacoras` | `/transporte/*` |
| Cars | `CarController` | `resources/views/cars` | `cars` | `/cars/*` |
| Drivers | `DriversController` | `resources/views/drivers` | `drivers` | `/drivers/*` |
| Concentrators | `ConcentratorController` | `resources/views/concentrator` | `concentrators` | `/concentrators/*` |
| Notas concentrator | `ConcentratorsNoteController`, `ConcentratorPaymentsController` | `resources/views/concentrator/note` | `concentrator_notas`, `concentrator_payments` | `/concentrator/*`, `/payment/*` |
| Mantenimiento concentrator | `ConcentratorMaintenanceController` | `resources/views/concentrator/maintenance` | `concentrator_maintenances` | `/concentratorsMaintenance/*` |
| PDF | `PDFController` | `resources/views/pdf` | Varias (segun el PDF) | `/pdf/*` |

## Reglas de negocio y flujos clave (resumen)

**Clientes**
- Alta requiere datos basicos y estatus.
- Si `tipo-cliente` es `EMPRESA`, `empresa` es obligatorio.
- Actualizacion valida correo, telefono, direccion y estatus.

**Clientes sin contrato**
- En personas fisicas concatena nombre + apellidos.
- Guarda datos de facturacion y envio.

**Contratos**
- Un mismo cliente no puede tener el mismo `tipo_contrato` duplicado.
- Valores negativos en deposito/transportes no son validos.
- Asignaciones en alta deben tener cantidades y precios > 0.
- No se permiten asignaciones duplicadas por combinacion de gas, tanque, material, capacidad y unidad.
- Al crear contrato se genera Nota de Asignacion con incidencia `INICIO-CONTRATO`.

**Asignaciones**
- Aumento requiere al menos un cambio positivo.
- Disminucion no puede dejar saldo negativo, si llega a 0 se elimina la asignacion.
- Se generan notas de asignacion con incidencia `aumento` o `disminucion`.

**Notas contrato (salida)**
- Si `monto_pago >= total` la nota queda pagada.
- Si no se cubre el total, se crea un pago inicial en `nota_pagos`.
- Cada tanque en salida pasa a estatus `ENTREGADO-CLIENTE`.
- Cancelar nota cambia estatus a `CANCELADA` y regresa tanques a `LLENO-ALMACEN`.

**Notas contrato (entrada)**
- Registra recargos y tanques devueltos.
- Si el tanque no existe se crea con datos parseados de descripcion.
- Si hay intercambio, el tanque cambiado pasa a `TANQUE-CAMBIADO` y en la nota se marca `CAMBIADO`.
- Cancelar nota cambia estatus a `CANCELADA` y pone tanques a `ENTREGADO-CLIENTE`.

**Pagos de notas**
- Suma pagos y marca nota como pagada cuando cubre el total.

**Notas exporadicas (mostrador)**
- Cantidad de tanques de entrada debe ser igual a la de salida.
- Entrada: si existe tanque, pasa a `VACIO-ALMACEN`; si no existe, se crea.
- Salida: tanque pasa a `VENTA-EXPORADICA`.
- Cancelar: entrada regresa a `VENTA-EXPORADICA` y salida regresa a `LLENO-ALMACEN`.

**Notas foraneas**
- Salida pone tanques en `VENTA-FORANEA`.
- Entrada valida duplicados de serie.
- Puede marcar pago cubierto y tanques devueltos.
- Cancelar revierte estatus segun incidencia.

**Notas talon**
- Registra entradas y luego salidas hasta igualar la cantidad.
- Salida pone tanques en `VENTA-TALON`.
- Cancelar elimina registros de salida y regresa tanque a `LLENO-ALMACEN`.

**Notas reserva**
- Incidencia `ENTRADA` pone tanques `LLENO-ALMACEN`.
- Incidencia `SALIDA` pone tanques `TANQUE-RESERVA`.
- Eliminar revierte estatus segun la incidencia.

**Tanques**
- Validacion de PH: alerta cerca de 10 anios.
- Baja marca `BAJA-TANQUE`, restablecer pasa a `VACIO-ALMACEN`.
- Reportados marcan `TANQUE-REPORTADO` y se pueden revertir.
- Historial consolida movimientos de notas, infra y mantenimiento.

**Infra**
- Salida genera nota con cantidad de salida y cambia tanques a `INFRA`.
- Entrada no puede superar cantidad salida.
- Entrada cambia tanques a `LLENO-ALMACEN`.

**Mantenimiento**
- Salida pone tanques en `MANTENIMIENTO`.
- Entrada regresa tanques a `LLENO-ALMACEN`.

**Transporte**
- No permite duplicar combinacion de fecha, vehiculo y chofer.
- Bitacora exige campos obligatorios y puede exportar PDF.

**Concentrators**
- Alta crea concentrator en `ALMACEN`.
- Nota de renta crea pago inicial `PAGADO` y cambia a `EN RENTA`.
- Devolucion suma horas trabajadas y regresa a `ALMACEN`.
- Mantenimiento cambia a `MANTENIMIENTO` y al cerrar vuelve a `ALMACEN`.

## Estados y transiciones relevantes

**Tanques**
- `VACIO-ALMACEN`, `LLENO-ALMACEN`, `ENTREGADO-CLIENTE`, `BAJA-TANQUE`, `TANQUE-REPORTADO`, `TANQUE-CAMBIADO`, `VENTA-EXPORADICA`, `VENTA-FORANEA`, `VENTA-TALON`, `INFRA`, `MANTENIMIENTO`, `TANQUE-RESERVA`.

**Notas y ventas**
- `notas`: `ACTIVA`, `CANCELADA`, `pago_cubierto`.
- `nota_foranea`: `pago_cubierto`, `tanques_devueltos`.
- `nota_talon`: `pendiente`.
- `infra_llenado` y `mantenimiento_llenado`: `pendiente`.

**Concentrators**
- `concentrators.status`: `ALMACEN`, `EN RENTA`, `MANTENIMIENTO`.
- `concentrator_notas.status`: `CERRADA`.
- `concentrator_payments.status`: `PAGADO`, `ADEUDA`.
- `concentrator_maintenances.status`: `PENDIENTE`, `OK`.

## Tareas para migracion (Spring Boot + Vue)

**1) Analisis y documentacion**
- Documentar reglas de negocio por modulo con casos reales.
- Validar estados, transiciones y permisos con usuarios.
- Definir alcance funcional por modulo y pantallas.
- Inventariar reportes y PDFs exactos requeridos.

**2) Diseno de arquitectura**
- Definir dominios y limites de servicio (DDD ligero o modular monolito).
- Definir esquema final de BD y mapeos desde Laravel.
- Definir estrategia de seguridad (JWT o session, RBAC).
- Definir contratos API (DTOs, validaciones, errores).

**3) Backend Spring Boot**
- Configurar proyecto base, seguridad, logging y perfiles.
- Implementar entidades y repositorios por modulo.
- Implementar servicios con reglas de negocio.
- Exponer APIs REST por pantalla y DataTables.
- Implementar generacion de PDF.
- Implementar auditoria basica (user_id, timestamps).

**4) Frontend Vue**
- Configurar app (router, store, axios, guardas).
- Implementar login, roles y permisos en UI.
- Migrar pantallas por modulo: listados, alta, edicion, detalle.
- Integrar tablas tipo DataTables o equivalente.
- Integrar vistas PDF y descarga.

**5) Migracion de datos**
- Diseñar scripts ETL y mapping de tablas.
- Normalizar estados y corregir datos inconsistentes.
- Migrar historicos de notas, pagos, bitacoras y mantenimientos.
- Validar conteos y sumas financieras post-migracion.

**6) Pruebas y calidad**
- Pruebas unitarias para reglas de negocio criticas.
- Pruebas de integracion para flujos completos.
- Pruebas de regresion en modulos de notas y tanques.

**7) DevOps y despliegue**
- Preparar entornos (dev, qa, prod).
- CI/CD y pipeline de migracion de BD.
- Monitoreo y respaldos.

## Orden recomendado de trabajo
1. Documentar reglas de negocio y estados por modulo con usuarios.
2. Definir modelo de datos final y plan de migracion.
3. Levantar esqueleto de Spring Boot + seguridad + RBAC.
4. Migrar modulos core: clientes, contratos, tanques, asignaciones.
5. Migrar notas contrato (salida/entrada) y pagos.
6. Migrar notas exporadicas, foraneas, talon y reserva.
7. Migrar infra y mantenimiento.
8. Migrar transporte, cars, drivers.
9. Migrar concentrators y pagos.
10. Migrar PDFs y reportes.
11. Cierre con QA funcional y migracion final de datos.

## Dudas abiertas que impactan la cotizacion
- Catalogo exacto de PDFs requeridos y sus formatos actuales.
- Alcance de permisos por rol y reglas especificas por negocio.
- Reglas de facturacion, CFDI y flujos de pagos parciales.
- Volumen de datos historicos y estrategia de migracion.
- Reglas para manejo de PH y vencimientos.

## Recomendacion principal
Antes de migrar, documenta y valida reglas de negocio y estados. Esto reduce retrabajo y permite definir un modelo de datos estable. En paralelo se puede ir armando la base tecnica (Spring Boot + Vue) para acelerar la fase de construccion.
