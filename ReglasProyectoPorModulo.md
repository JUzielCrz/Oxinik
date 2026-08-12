# Reglas del proyecto por modulo

Fecha de analisis: 2026-05-27

Este documento resume reglas encontradas por lectura estatica del codigo actual. Las fuentes principales fueron `routes/web.php`, controladores en `app/Http/Controllers`, modelos en `app/Models`, migraciones en `database/migrations`, vistas en `resources/views` y documentacion existente del proyecto. No sustituye validacion funcional con usuarios finales.

## Reglas generales del sistema

- El proyecto es Laravel 7 con PHP 7.4.
- La aplicacion usa sesiones web y `Auth::routes()`.
- La mayoria de modulos requieren usuario autenticado mediante middleware `auth`.
- La UI principal esta en Blade y usa DataTables para listados.
- Los PDFs se generan con DomPDF desde vistas Blade.
- Las respuestas de operaciones AJAX suelen ser JSON con mensajes como `Registrado Correctamente`, `Editado Correctamente`, `Sin permisos` o indicadores `alert`.
- Muchos listados formatean fechas como `Y/m/d - H:i:s A`.
- Los cambios de inventario se reflejan principalmente cambiando el campo `estatus` de `tanques`.
- Cuando se guardan notas o movimientos, se registra `user_id` con el usuario autenticado en los flujos donde el controlador lo implementa.

## Autenticacion, roles y permisos

- El usuario con rol `admin` pasa cualquier permiso evaluado con `permiso_con_admin`.
- `permiso_sin_admin` solo valida permisos asignados al rol, sin privilegio implicito de admin.
- `soloParaUnRol` valida si el usuario tiene un rol especifico.
- Usuarios y roles estan restringidos a usuarios con rol `admin`.
- Para crear usuario se requiere `name`, `email` unico, `password` minimo de 8 caracteres y confirmacion.
- Para crear o actualizar usuario se debe seleccionar al menos un rol.
- Para actualizar usuario, `name` y `email` deben seguir siendo unicos ignorando el usuario actual.
- Para crear rol se requiere `name` unico, `slug` unico y al menos un permiso.
- Para actualizar rol, `name` y `slug` deben seguir siendo unicos ignorando el rol actual y debe haber al menos un permiso.
- El permiso operativo por modulo se expresa con slugs como `cliente_show`, `cliente_create`, `nota_salida`, `tanque_delete`, `infra_entrada`, `concentrator_show`, entre otros.

## Perfil

- Cambio de password, cambio de email y datos personales requieren usuario autenticado.
- El controlador valida los campos antes de actualizar los datos del usuario.

## Configuracion de empresa

- La configuracion de empresa vive en `datos_empresa` y `config_sistem`.
- Los datos de empresa se usan como fuente para varios PDFs.
- La ruta principal del modulo es `/config/empresa/index`.

## Catalogo de gases

- El modulo requiere permisos `gas_show`, `gas_create`, `gas_update` o `gas_delete` segun la accion.
- Para crear gas, `nombre` y `abreviatura` son obligatorios y unicos.
- Para actualizar gas, `nombre` y `abreviatura` deben seguir siendo unicos ignorando el registro actual.
- El catalogo completo se expone por `/catalogo_gases`.
- El nombre de gas se obtiene por id cuando se muestra informacion de tanques.

## Clientes

- El modulo requiere permisos `cliente_show`, `cliente_create`, `cliente_update` o `cliente_delete`.
- Los listados filtran clientes por `estatus`.
- Para crear cliente se requiere `tipo-cliente`, apellidos, nombre, RFC, telefono, telefono de respaldo y estatus.
- Si `tipo-cliente` es `EMPRESA`, el campo `empresa` es obligatorio.
- Para actualizar cliente tipo `PERSONA`, se requieren apellidos y nombre.
- Para actualizar cliente tipo `EMPRESA`, se requiere `empresa`.
- En actualizacion son obligatorios RFC, email valido, telefono, telefono de respaldo, direccion, referencia y estatus.
- El cliente puede tener contratos asociados desde el listado.
- La eliminacion de cliente es eliminacion fisica del registro.

## Clientes sin contrato

- Se usan para notas de mostrador, foraneas, talon, reserva y concentradores.
- La busqueda acepta coincidencias por id o nombre.
- Para crear cliente sin contrato se requiere `tipo_persona` y `nombre`.
- Si `tipo_persona` es `Fisica`, se requieren apellido paterno y materno.
- Para persona fisica, el nombre guardado concatena nombre, apellido paterno y apellido materno.
- Se guardan datos de contacto, RFC, CFDI, direccion de factura, direccion de envio, referencia, link de ubicacion y precio de envio.
- Para actualizar se requiere nombre y se reemplazan los datos fiscales/envio/contacto.

## Contratos

- El modulo requiere permisos `contrato_show`, `contrato_create`, `contrato_update` o `contrato_delete`.
- Un contrato pertenece a un cliente.
- Para crear o actualizar contrato se requiere `cliente_id` y `tipo_contrato`.
- No se permite que el mismo cliente tenga duplicado el mismo `tipo_contrato`.
- `deposito_garantia` y `precio_transporte` no pueden ser negativos.
- En la asignacion inicial, cilindros, precio unitario y capacidad deben ser mayores o iguales a 1.
- Las asignaciones iniciales no pueden tener campos vacios de gas, material, tipo de tanque, precio, deposito, capacidad o unidad de medida.
- No se permiten asignaciones duplicadas por combinacion de gas, tipo de tanque, tipo de contrato, material, capacidad y unidad de medida.
- Al crear contrato se guardan datos de renta/transporte, direccion, referencias, reguladores, observaciones y obligado solidario.
- Al crear contrato se crean asignaciones de tanques asociadas.
- Al crear contrato se genera nota de asignacion con incidencia `INICIO-CONTRATO`.
- Los detalles de nota de asignacion se agrupan por gas, tipo de tanque, material, capacidad y unidad.
- La eliminacion de contrato es eliminacion fisica.
- El listado de contratos puede filtrar por estatus del cliente y por tipo de contrato.

## Asignaciones

- El aumento requiere permiso `asignacion_aumento`.
- La disminucion requiere permiso `asignacion_disminucion`.
- El cambio de precio unitario requiere permiso `contrato_update`.
- En aumentos, cada fila debe tener variante no negativa, gas, tipo de tanque, material, unidad, deposito y valores no negativos de precio/capacidad.
- Un aumento requiere al menos un cambio positivo.
- No se permiten asignaciones repetidas por gas, tipo de tanque, material, capacidad y unidad de medida.
- Si la asignacion ya existe, el aumento suma cilindros.
- Si la asignacion no existe, el aumento crea una nueva asignacion.
- Cada aumento genera nota de asignacion con incidencia `aumento`.
- En disminucion debe existir al menos una variante positiva.
- La disminucion no puede dejar cilindros negativos.
- Si la disminucion deja una asignacion en cero, la asignacion se elimina.
- Cada disminucion genera nota de asignacion con incidencia `disminucion`.
- El precio unitario no puede ser nulo, vacio ni negativo.

## Tanques

- El modulo requiere permisos `tanque_show`, `tanque_create`, `tanque_update`, `tanque_delete`, `tanque_history` o `tanque_report`.
- Para crear tanque se requiere serie unica, PH, capacidad, material, fabricante, tipo de gas, estatus y tipo de tanque.
- Para actualizar tanque, la serie debe seguir siendo unica ignorando el tanque actual.
- El listado principal excluye tanques con estatus `BAJA-TANQUE` y `TANQUE-REPORTADO`.
- Baja logica cambia estatus a `BAJA-TANQUE`.
- Restablecer una baja cambia estatus a `VACIO-ALMACEN`.
- La eliminacion directa de tanque borra fisicamente el registro.
- Reportar tanque crea un registro en `tanques_reportados` y cambia estatus a `TANQUE-REPORTADO`.
- Eliminar reporte borra el reporte y cambia el tanque a `VACIO-ALMACEN` si el tanque existe.
- La validacion de PH marca vencido con 10 anios o mas.
- La validacion de PH alerta cuando esta cerca de vencimiento entre 9 anios 7 meses y 10 anios.
- El historial del tanque consolida creacion, actualizacion, infra, mantenimiento, notas foraneas, notas contrato, notas talon, notas reserva y notas de mostrador.
- `validar_talon` detecta si una serie esta en una nota talon pendiente.

## Estados principales de tanques

- `VACIO-ALMACEN`: tanque disponible vacio.
- `LLENO-ALMACEN`: tanque disponible lleno.
- `ENTREGADO-CLIENTE`: tanque entregado en nota de contrato.
- `BAJA-TANQUE`: tanque dado de baja.
- `TANQUE-REPORTADO`: tanque reportado.
- `TANQUE-CAMBIADO`: tanque sustituido/intercambiado.
- `VENTA-EXPORADICA`: tanque usado en nota de mostrador.
- `VENTA-FORANEA`: tanque usado en nota foranea.
- `VENTA-TALON`: tanque usado en nota talon.
- `TANQUE-RESERVA`: tanque en reserva/transporte.
- `INFRA`: tanque enviado a llenado infra.
- `MANTENIMIENTO`: tanque enviado a mantenimiento.

## Notas de contrato - salida

- Requiere permiso `nota_salida`.
- Para guardar salida se requiere contrato, total numerico y monto de pago numerico.
- Debe haber al menos un tanque en la salida.
- Si `monto_pago` es mayor o igual que el total, `pago_cubierto` queda verdadero.
- Si `monto_pago` no cubre el total, se crea un registro en `nota_pagos` con el primer pago.
- Al guardar salida se registran subtotal, IVA general, envio, total, metodo de pago, observaciones y usuario.
- Cada tanque de salida se guarda en `nota_tanque`.
- Cada tanque de salida cambia estatus a `ENTREGADO-CLIENTE`.
- La salida valida que el tanque corresponda a una asignacion del contrato por gas, tipo de tanque y material.
- Cancelar salida cambia la nota a `CANCELADA` y devuelve todos los tanques a `LLENO-ALMACEN`.
- La informacion de envio del contrato puede actualizarse desde el flujo de nota.

## Notas de contrato - entrada

- Requiere permiso `nota_entrada`.
- Para guardar entrada se requiere total numerico y contrato numerico.
- Debe haber al menos un tanque en la entrada.
- Se registra una nota de entrada con metodo de pago, recargos, observaciones y usuario.
- Si el tanque devuelto existe, cambia a `VACIO-ALMACEN`.
- Si el tanque devuelto no existe, se crea a partir de la descripcion recibida.
- Si no hay intercambio (`SN`), el registro pendiente de `nota_tanque` se marca `DEVUELTO`.
- Si hay intercambio, el tanque original se marca `CAMBIADO` en `nota_tanque`.
- Si hay intercambio, el tanque cambiado pasa a estatus `TANQUE-CAMBIADO`.
- Cada tanque devuelto se guarda en `notas_entrada_tanque` con tapa e intercambio.
- Cancelar entrada cambia la nota a `CANCELADA` y regresa los tanques a `ENTREGADO-CLIENTE`.

## Pagos de notas

- Los pagos estan asociados a notas de contrato.
- Crear pago registra monto, metodo de pago, nota y usuario.
- Despues de crear pago se suma el total pagado de la nota.
- Si la suma de pagos es mayor o igual al total de la nota, `pago_cubierto` cambia a verdadero.

## Listados de notas contrato

- El listado de salidas muestra pago como `Pagado` o `Adeuda`.
- Adeudos filtra notas activas con `pago_cubierto = false`.
- Los listados exponen botones para PDF, pagos, consulta y cancelacion.

## Notas exporadicas / mostrador

- Requiere permiso `nota_exporadica` para crear/listar.
- Para guardar se requiere cliente sin contrato, metodo de pago, subtotal y total.
- La cantidad de tanques de entrada debe ser igual a la cantidad de tanques de salida.
- Debe existir al menos un tanque de entrada o salida.
- La nota copia datos fiscales, contacto y envio del cliente sin contrato.
- Cada tanque de entrada existente cambia a `VACIO-ALMACEN`.
- Cada tanque de entrada inexistente se crea a partir de la descripcion.
- Cada tanque de entrada se guarda con incidencia `ENTRADA`.
- Cada tanque de salida cambia a `VENTA-EXPORADICA`.
- Cada tanque de salida se guarda con incidencia `SALIDA`, cantidad, unidad, tapa, IVA e importe.
- Cancelar nota cambia estatus a `CANCELADA`.
- Al cancelar, tanques de incidencia `ENTRADA` cambian a `VENTA-EXPORADICA`.
- Al cancelar, tanques de incidencia `SALIDA` cambian a `LLENO-ALMACEN`.

## Notas foraneas

- Requiere permiso `nota_foranea`.
- Usuarios admin ven todas las notas; otros usuarios ven solo sus notas.
- Para crear salida se requiere cliente sin contrato, metodo de pago, subtotal y total.
- Debe haber al menos un tanque de salida.
- Si metodo de pago es `Credito`, `pago_cubierto` queda falso.
- Cada tanque de salida cambia a `VENTA-FORANEA`.
- En entrada/edicion se rechazan series repetidas en entrada o salida.
- Si `pago_cubierto` viene nulo, se interpreta como pagado.
- La edicion actualiza subtotal, IVA, total y `tanques_devueltos`.
- Las entradas existentes cambian tanque a `VACIO-ALMACEN`.
- Las entradas inexistentes crean tanque a partir de la descripcion.
- Quitar un tanque de salida borra el detalle y regresa el tanque a `LLENO-ALMACEN`.
- Quitar un tanque de entrada borra el detalle y cambia el tanque a `VENTA-FORANEA`.
- Eliminar nota revierte entradas a `VENTA-FORANEA`, salidas a `LLENO-ALMACEN` y borra la nota.

## Notas talon

- Requiere permiso `nota_talon`.
- El listado puede filtrar por `pendiente` o mostrar `ALL`.
- Para crear nota se requiere cliente sin contrato.
- Para crear nota debe haber al menos un tanque de entrada.
- Cada entrada existente cambia a `VACIO-ALMACEN`.
- Cada entrada inexistente crea tanque a partir de la descripcion.
- La edicion requiere cliente, subtotal y total.
- En salida se rechazan series repetidas.
- La cantidad de tanques de salida no puede superar la cantidad de tanques de entrada.
- Cada tanque de salida cambia a `VENTA-TALON`.
- Quitar un tanque de salida borra el detalle y regresa el tanque a `LLENO-ALMACEN`.
- Eliminar nota cambia tanques de incidencia `ENTRADA` a `VENTA-TALON` y borra la nota.

## Notas reserva

- Requiere permiso `nota_reserva` para vista, alta, consulta y eliminacion.
- La nota reserva registra usuario, incidencia, chofer y vehiculo.
- Si incidencia es `ENTRADA`, los tanques cambian a `LLENO-ALMACEN`.
- Si incidencia es `SALIDA`, los tanques cambian a `TANQUE-RESERVA`.
- Cada tanque se guarda en `nota_reserva_tanque`.
- El listado principal muestra notas del usuario autenticado y limita a 200 registros.
- Tanques pendientes filtra tanques con estatus `TANQUE-RESERVA`.
- Al eliminar una nota `SALIDA`, los tanques vuelven a `LLENO-ALMACEN`.
- Al eliminar una nota distinta de `SALIDA`, los tanques vuelven a `TANQUE-RESERVA`.
- El PDF usa datos de empresa y tanques asociados.

## Infra

- Acceso al indice requiere permiso `infra_salida` o `infra_entrada`.
- La salida requiere permiso `infra_salida`.
- La entrada requiere permiso `infra_entrada`, aunque algunos guardados aceptan salida o entrada.
- Para salida se requiere `cantidad` entera.
- Salida crea registro en `infra_llenado` con cantidad de salida y usuario.
- Cada tanque de salida se guarda con incidencia `SALIDA` y cambia estatus a `INFRA`.
- Para entrada se requiere `cantidad_entrada` entera.
- La cantidad de entrada no puede ser mayor que la cantidad de salida.
- Si `pendiente` llega nulo, el movimiento queda pendiente.
- Entrada actualiza cantidad entrada, diferencia, pendiente, observaciones y usuario.
- Cada tanque de entrada nuevo para esa nota se guarda con incidencia `ENTRADA` y cambia a `LLENO-ALMACEN`.
- El listado muestra diferencia solo si el movimiento esta pendiente.

## Mantenimiento de tanques

- Acceso al indice requiere permiso `mantenimiento_salida` o `mantenimiento_entrada`.
- Salida requiere `cantidad` entera e `incidencia`.
- Salida crea nota de mantenimiento con fecha actual.
- Cada tanque de salida queda en `MANTENIMIENTO`.
- En salida se actualiza PH del tanque con `inputPH`.
- Entrada requiere `cantidad` entera e `incidencia`.
- Entrada actualiza el indicador `pendiente` de la nota.
- Cada tanque de entrada queda en `LLENO-ALMACEN`.
- En entrada tambien se actualiza PH del tanque con `inputPH`.

## Transporte

- El modulo usa `drivers` y `cars`.
- Para crear transporte se requiere fecha, vehiculo y chofer.
- No se permite duplicar la combinacion fecha + vehiculo + chofer.
- La actualizacion guarda kilometraje inicial/final, envases, acomuladores y observaciones.
- El filtro puede aplicar fecha, vehiculo y/o chofer.
- Al eliminar transporte se borran primero sus bitacoras.

## Bitacora de transporte

- Para crear entrada de bitacora se requieren lugar de salida, lugar de llegada, hora salida, hora entrada, carga, descarga y total.
- Observaciones son opcionales.
- La bitacora queda asociada a un transporte.
- El PDF de bitacora se genera en papel carta horizontal e incluye empresa, vehiculo, chofer y registros.

## Cars y drivers

- Existen como catalogos usados por transporte y reserva.
- Sus controladores usan validaciones basicas de campos requeridos.
- Tienen rutas `Route::resource` y endpoint de datos para tabla.

## Concentrators

- El modulo requiere permiso `concentrator_show` para CRUD principal.
- Para crear concentrador se requiere serie, marca, horas de trabajo, capacidad y descripcion.
- Todo concentrador nuevo inicia con status `ALMACEN`.
- La actualizacion permite cambiar serie, marca, horas, capacidad y descripcion.
- Se puede buscar concentrador por numero de serie.

## Notas de concentrator

- El acceso del controlador valida el permiso `drivers_show`.
- Al crear nota se busca concentrador por serie y cliente sin contrato por id.
- La nota copia datos del cliente sin contrato.
- Al crear nota se crea un primer pago con status `PAGADO`.
- El primer pago guarda periodo, precios, deposito, fechas, horas de salida, total, metodo de pago y usuario.
- Al crear nota, el concentrador cambia a `EN RENTA`.
- Devolver concentrador suma horas consumidas a `work_hours`.
- Devolver concentrador cambia el concentrador a `ALMACEN` y registra fecha de devolucion.
- Cerrar nota cambia su status a `CERRADA`.
- El PDF de nota usa datos de empresa y primer pago.

## Pagos de concentrator

- Crear pago adicional lo registra con status `ADEUDA`.
- El pago adicional guarda periodo, precios, deposito, fechas, total y usuario.
- Si el pago ya esta `PAGADO`, no se puede registrar de nuevo.
- Registrar pago cambia status a `PAGADO` y guarda metodo de pago.
- Los PDFs usan una vista distinta si el pago no tiene `work_hours_output`.
- Los pagos se pueden eliminar fisicamente.

## Mantenimiento de concentrator

- Requiere permiso `concentrator_show`.
- Para enviar a mantenimiento se requiere serie de concentrador.
- El mantenimiento nuevo queda `PENDIENTE`.
- Al crear mantenimiento, el concentrador cambia a `MANTENIMIENTO`.
- Si el mantenimiento ya esta `OK`, no puede actualizarse de nuevo.
- Cuando `status_edit` es `OK`, se registra fecha de retorno, el concentrador vuelve a `ALMACEN`, se suman horas trabajadas y el mantenimiento queda `OK`.
- Al eliminar mantenimiento, el concentrador vuelve a `ALMACEN` y se borra el mantenimiento.

## PDFs

- Existen PDFs para asignacion de tanque, nota contrato, contrato, nota exporadica, nota foranea, nota talon, infra, mantenimiento, reserva, transporte y concentrator.
- Los PDFs usan vistas en `resources/views/pdf`, `resources/views/notas/reserva`, `resources/views/transporte` y `resources/views/concentrator`.
- Varias plantillas usan `DatosEmpresa::find(1)` como fuente de datos de empresa.

## Estados de notas y pagos

- `notas` y `notas_entrada` usan `ACTIVA` y `CANCELADA`.
- `nota_tanque` usa `PENDIENTE`, `DEVUELTO` y `CAMBIADO`.
- `nota_foranea` maneja `pago_cubierto` y `tanques_devueltos`.
- `nota_talon` maneja `pendiente`.
- `infra_llenado` y `mantenimiento_llenado` manejan `pendiente`.
- `concentrator_notas` usa `ABIERTA` y `CERRADA`.
- `concentrator_payments` usa `PAGADO` y `ADEUDA`.
- `concentrator_maintenances` usa `PENDIENTE` y `OK`.
- `concentrators` usa `ALMACEN`, `EN RENTA` y `MANTENIMIENTO`.

## Observaciones de calidad encontradas

- Hay reglas de negocio implementadas directamente en controladores.
- Algunos permisos parecen inconsistentes entre nombre de modulo y slug usado, por ejemplo notas reserva valida `nota_talon` en algunos listados y notas concentrator valida `drivers_show`.
- Varias operaciones de eliminacion son borrado fisico y otras son cambio de estatus.
- Varias transiciones de estatus no estan centralizadas.
- Algunas rutas usan `GET` para acciones destructivas como delete/cancelar.
- Hay campos y mensajes con nombres historicos o typos, por ejemplo `exporadica`, `insidencia`, `acomuladores` y `config_sistem`.
- El documento se debe validar contra pruebas funcionales antes de usarlo como contrato de migracion o reimplementacion.
