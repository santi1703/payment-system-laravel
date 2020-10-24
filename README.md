Cree el esquema utilizando herramientas de terceros, al igual que el código SQL fue generado automáticamente por herramientas de terceros.

https://app.sqldbm.com/ fue utilizada para crear el diagrama, HeidiSQL fue utilizado para generar el código SQL.



Para las tablas correspondientes a modelos del framework de PHP utilizado (Laravel) se utilizó la clave y nomenclatura estándar del framework (una columna llamada id de tipo int autoincremental y siendo ésta columna clave primaria de cada respectiva tabla).

La tabla que primero fue creada fue users, para almacenar datos de usuarios, se incluyeron columnas para guardar nombre, apellido e email, además de los campos por defecto de la migración incorporada por Laravel, no vi necesario remover campos para éste ejercicio.

La siguiente tabla fue teams, para almacenar datos de equipos, en éste caso se guarda el nombre del equipo, además del id que es su clave primaria, por el motivo aclarado al comienzo.

Cree una tabla para una relación de muchos a muchos entre usuarios y equipos, considerando que un usuario pueda pertenecer a más de un equipo, y asimismo los equipos pueden tener más de un usuario que lo integre. En ésta tabla creé una clave primaria compuesta que integra user_id y team_id para no permitir agregar reiteradas veces la relación entre mismo usuario y equipo, además éstas dos columnas fueron marcadas como claves foráneas referenciando a las respectivas tablas. Se agregó además una columna responsable, de tipo tinyint en la que se marca el usuario responsable del pago de las facturas de las suscripciones.

La siguiente tabla creada fue subscriptions, en la que se guardan los datos de los servicios de suscripción, ademas de las columnas y nombre, se agregó una columna booleana para guardar el estado del servicio (suponiendo que pudiera dejar de ser un servicio activo al cual pudieran suscribirse los equipos)

La relación entre equipos y teams es de muchos a muchos, por lo que se creó la tabla intermedia subscriptions_teams, la tabla tiene los campos subscription_id y team_id para establecer la relación entre las respectivas tablas. En ésta tabla consideré agregar una columna id para poder ser referenciada en la tabla invoices.

Para la facturación se creó la tabla invoices, que representa cada factura emitida por servicio y equipo, el pago se representa cuando la columna paid_on y paid_by tengan un valor distinto de NULL. Ésta tabla contiene una columna created_on que almacena la fecha de emisión del comprobante, un campo amount con el precio que resulte del cálculo correspondiente por el equipo al que le sea facturado el servicio, y una columna subscribtion_team_id que referencia a que subscripción de que team corresponde el comprobante. El comprobante guarda el nombre de quién realizó el pago, considerando que eventualmente el responsable del equipo pudiera cambiar.

Sé que hay varias posibilidades de mejora, y que hay casos que no terminé de resolver con ésta estructura, a mi mismo se me ocurre más de uno, por ejemplo acciones a tomar en cuenta con las tablas foráneas para evitar conflictos al momento de remover registros de tablas relacionadas a otras, pero ahora mismo con el tiempo apremiando no podría dar una completa solución a casos de ése tipo, y para los puntos del ejercicio no generarían mayores conflictos.


Para el tercer punto del ejercicio, se agrega la tabla geolocations, en la cual se registran las coordenadas de la localización, y el id del usuario del que corresponda el registro, además se agrega una columna taken_on con la fecha correspondiente del registro, considerando que la información pudiera ser relevante para posteriores análisis o estadísticas.


Las rutas definidas son /locate para el punto 5 del ejercicio y /teams para el punto 6.
