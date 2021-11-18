--------------------------------------------------------------------------ASIGNACIONES 1--------------------------------------------------------------------------

--creación de tablas
Create table KT_PROCESOS(
	ROWID Serial,
	PROCESO_ID varchar(10) primary key,
	DESCRIPCION varchar(128)
); 

Create table KT_CORRELATIVOS(
	PROCESO_ID varchar(10) references KT_PROCESOS(PROCESO_ID),
	CORRELATIVO_ID varchar(10) primary key,
	ULTIMO_NUM_UTILIZADO integer
); 

Create table KT_DECISIONES_OR(
	ROWID Serial,
	DECISION_OR_ID varchar(10) primary key,
	TIPO varchar(1),
	DESCRIPCION varchar(128),
	NIVEL integer,
	RGBCOLOR varchar(15)
); 

Create table KT_EFICACIACONTROLES(
	ROWID Serial,
	EFICACIA_ID varchar(10) primary key,
	DESCRIPCION varchar(128),
	INTENSIDAD integer
);

Create table KT_ELEMENTOSIMPACTO(
	ROWID Serial,
	ELEMENTOIMPACTO_ID varchar(10) primary key,
	DESCRIPCION varchar(128),
	INTENSIDAD integer
);

Create table KT_FACTIBILIDAD(
	ROWID Serial,
	FACTIBILIDAD_ID varchar(10) primary key,
	DESCRIPCION varchar(128),
	INTENSIDAD integer,
	RGBCOLOR varchar(15)
);

Create table KT_IMPACTOS(
	ROWID Serial,
	IMPACTO_ID varchar(10) primary key,
	TIPO varchar(1),
	DESCRIPCION varchar(128),
	INTENSIDAD integer,
	RGBCOLOR varchar(15)
);

Create table KT_OBJETIVOSCALIDAD(
	ROWID Serial,
	OBJETIVOCALIDAD_ID varchar(10) primary key,
	DESCRIPCION varchar(128),
	PALABRA_CLAVE varchar(128)
);

Create table KT_INDICADORES(
	ROWID Serial,
	PROCESO_ID varchar(10) references KT_PROCESOS(PROCESO_ID),
	INDICADOR_ID varchar(10) primary key,
	NOMBRE varchar(240),
	OBJETIVOCALIDAD_ID varchar(10) references KT_OBJETIVOSCALIDAD(OBJETIVOCALIDAD_ID),
	OBJETIVO_ESPECÍFICO varchar(240),
	FÓRMULA_DE_CALCULO varchar(480),
	VALOR_ACTUALIDAD varchar(128),
	VALOR_POTENCIALIDAD varchar(128),
	META varchar(128),
	FRECUENCIA_MEDICION varchar(128),
	RESPONSABLE_MEDICION varchar(128),
	RESPONSIBLE_SEGUIMIENTO varchar(128),
	FUENTE_INFORMACIÓN varchar(128)
);

Create table KT_NIVEL_OR(
	ROWID Serial,
	NIVEL_OR_ID varchar(10) primary key,
	TIPO varchar(1),
	DESCRIPCION varchar(128),
	INTENSIDAD integer,
	RGBCOLOR varchar(15)
);

Create table KT_PARTES_INTERESADAS(
	ROWID Serial,
	PROCESO_ID varchar(10) references KT_PROCESOS(PROCESO_ID),
	PARTE_INTERESADA_ID varchar(10) primary key,
	DESCRIPCION varchar(128),
	REQUISITO_IDENTIFICADO varchar(250),
	LAST_USER varchar(128)
);

Create table KT_PROBABILIDADESOCURRENCIA(
	ROWID Serial,
	PROBABILIDAD_ID varchar(10) primary key,
	DESCRIPCION varchar(128),
	INTENSIDAD integer,
	RGBCOLOR varchar(15)
);

Create table KT_TIPOSMATRIZ(
	ROWID Serial,
	TIPOMATRIZ_ID varchar(10) primary key,
	DESCRIPCION varchar(256),
	CLASIFICACION varchar(1)
);

Create table KT_TIPOSPARTESINTERESADAS(
	ROWID Serial,
	TIPOPI_ID varchar(10) primary key,
	DESCRIPCION varchar(128)
);

Create table KT_USERSAPP(
	ROWID Serial,
	USER_ID varchar(128) primary key,
	PASSWORD varchar(128),
	LEVEL varchar(1),
	CORREO VARCHAR(100),
	ESTADO integer
);

Create table KT_USUARIOSCROSS(
	ROWID Serial,
	USER_ID varchar(128) references KT_USERSAPP(USER_ID),
	PROCESO_ID varchar(10) references KT_PROCESOS(PROCESO_ID),
	ROL integer
);

Create table MATRICES(
	ROWID Serial,
	MATRIZ_ID varchar(128) primary key,
	TIPOMATRIZ_ID varchar(10) references KT_TIPOSMATRIZ(TIPOMATRIZ_ID),
	OBJETIVOCALIDAD_ID varchar(10) references KT_OBJETIVOSCALIDAD(OBJETIVOCALIDAD_ID),
	PROCESO_ID varchar(10) references KT_PROCESOS(PROCESO_ID),
	INDICADOR_ID varchar(10) references KT_INDICADORES(INDICADOR_ID),
	PARTE_INTERESADA_ID varchar(10) references KT_PARTES_INTERESADAS(PARTE_INTERESADA_ID),
	PROCESO_ELEMENTO varchar(250),
	CLASIFICACION_MATRIZ varchar(1),
	RO_NUM integer,
	EDICION_NUM integer,
	STATUS varchar(15),
	ENTRADA varchar(250),
	ACTIVIDAD varchar(250),
	SALIDA varchar(250),
	OPORTUNIDAD varchar(250),
	RIESGO varchar(250),
	ETAPA varchar(250),
	MERCADO_E_IMAGEN varchar(10),
	AFECTACION_RECURSOS varchar(10),
	CUMPLIMIENTO_REQUISITOS varchar(10),
	MEDIO_AMBIENTE varchar(10),
	RESPONSABILIDAD_SOCIAL varchar(10),
	SEGURIDAD varchar(10),
	CONSECUENCIA varchar(250),
	CONTROLES_EXISTENTES varchar(3000),
	EFICACIA_ID varchar(10) references KT_EFICACIACONTROLES(EFICACIA_ID),
	CAUSA varchar(250),
	FACTIBILIDAD_ID varchar(10) references KT_FACTIBILIDAD(FACTIBILIDAD_ID),
	IMPACTO_ID varchar(10) references KT_IMPACTOS(IMPACTO_ID),
	RESULTADO varchar(250),
	NIVEL_OR_ID varchar(10) references KT_NIVEL_OR(NIVEL_OR_ID),
	DECISION_OR_ID varchar(10) references KT_DECISIONES_OR(DECISION_OR_ID),
	PROBABILIDAD_ID varchar(10) references KT_PROBABILIDADESOCURRENCIA(PROBABILIDAD_ID),
	LAST_USER varchar(128)
); 

Create table MATRICES_ACCIONES(
	ROWID Serial,
	MATRIZ_ID varchar(128) references MATRICES(MATRIZ_ID),
	PROCESO_ELEMENTO varchar(250),
	EDICION_NUM integer,
	ACCION_NUM integer,
	ACCION_PROPUESTA varchar(250),
	RESPONSABLE_ACCION varchar(250),
	CARGO_RESPONSABLE varchar(250),
	RECURSOS_REQUERIDOS varchar(2056),
	REQUIERE_AUT varchar(250),
	FECHA_PLANEADA Date,
	FECHA_EJECUTADA Date,
	FECHA_SEGUIMIENTO Date,
	RESPONSABLE_SEGUIMIENTO varchar(250),
	CARGO_SEGUIMIENTO varchar(250),
	RESULTADO_SEGUIMIENTO varchar(250),
	NIVEL_REDUCIDO_PROBABILIDAD_ID varchar(10),
	NIVEL_REDUCIDO_IMPACTO_ID varchar(10),
	NIVEL_REDUCIDO_RIESGO_ID varchar(10),
	REQUIERE_AC varchar(1),
	REFERENCIA_AC varchar(30),
	LAST_USER varchar(128),
	CTRL_CIERRE_AC varchar(1),
	FECHA_CIERRE_AC Date,
	ESTADO_ACCION varchar(15),
	EVIDENCIAS varchar(250)
);

--consultas select a cada tabla
select* from KT_PROCESOS;--
select* from KT_CORRELATIVOS;--
select* from KT_DECISIONES_OR;--
select* from KT_EFICACIACONTROLES;--
select* from KT_ELEMENTOSIMPACTO;--
select* from KT_FACTIBILIDAD;--
select* from KT_IMPACTOS; --
select* from KT_INDICADORES;--
select* from KT_NIVEL_OR;--
select* from KT_OBJETIVOSCALIDAD;--
select* from KT_PARTES_INTERESADAS;--
select* from KT_PROBABILIDADESOCURRENCIA;--
select* from KT_TIPOSMATRIZ;--
select* from KT_TIPOSPARTESINTERESADAS;--
select* from KT_USERSAPP;--
select* from KT_USUARIOSCROSS;--
select* from MATRICES;--
select* from MATRICES_ACCIONES;--

SELECT I.ROWID , P.DESCRIPCION, I.INDICADOR_ID, I.NOMBRE , O.DESCRIPCION AS descrip, I.OBJETIVO_ESPECÍFICO AS objetivoes, I.FÓRMULA_DE_CALCULO AS formula, 
I.VALOR_ACTUALIDAD, I.VALOR_POTENCIALIDAD, I.META, I.FRECUENCIA_MEDICION, I.RESPONSABLE_MEDICION, I.RESPONSIBLE_SEGUIMIENTO, I.FUENTE_INFORMACIÓN AS fuente
FROM KT_INDICADORES I JOIN KT_PROCESOS P USING(PROCESO_ID) JOIN KT_OBJETIVOSCALIDAD O USING(OBJETIVOCALIDAD_ID) ORDER BY I.ROWID;

SELECT I.ROWID , P.DESCRIPCION, I.INDICADOR_ID, I.NOMBRE , O.PALABRA_CLAVE AS descrip, I.OBJETIVO_ESPECÍFICO AS objetivoes, I.FÓRMULA_DE_CALCULO AS formula, 
I.VALOR_ACTUALIDAD, I.VALOR_POTENCIALIDAD, I.META, I.FRECUENCIA_MEDICION, I.RESPONSABLE_MEDICION, I.RESPONSIBLE_SEGUIMIENTO, I.FUENTE_INFORMACIÓN AS fuente
FROM KT_INDICADORES I JOIN KT_PROCESOS P USING(PROCESO_ID) JOIN KT_OBJETIVOSCALIDAD O USING(OBJETIVOCALIDAD_ID)  WHERE P.DESCRIPCION ILIKE'%E%' OR I.INDICADOR_ID ILIKE'%E%' 
OR I.NOMBRE ILIKE'%E%' OR O.PALABRA_CLAVE ILIKE'%EF%' OR I.OBJETIVO_ESPECÍFICO ILIKE'%E%' OR I.FÓRMULA_DE_CALCULO ILIKE'%E%' OR I.VALOR_ACTUALIDAD ILIKE'%E%' OR I.VALOR_POTENCIALIDAD ILIKE'%E%'
OR I.META ILIKE'%E%' OR I.FRECUENCIA_MEDICION ILIKE'%E%' OR I.RESPONSABLE_MEDICION ILIKE'%E%' OR I.FUENTE_INFORMACIÓN ILIKE'%E%' ORDER BY I.ROWID;

SELECT I.ROWID , P.DESCRIPCION, I.INDICADOR_ID, I.NOMBRE , O.PALABRA_CLAVE AS descrip, I.OBJETIVO_ESPECÍFICO AS objetivoes, I.FÓRMULA_DE_CALCULO AS formula, 
I.VALOR_ACTUALIDAD, I.VALOR_POTENCIALIDAD, I.META, I.FRECUENCIA_MEDICION, I.RESPONSABLE_MEDICION, I.RESPONSIBLE_SEGUIMIENTO, I.FUENTE_INFORMACIÓN AS fuente
FROM KT_INDICADORES I JOIN KT_PROCESOS P USING(PROCESO_ID) JOIN KT_OBJETIVOSCALIDAD O USING(OBJETIVOCALIDAD_ID)  WHERE I.ROWID = 5;

UPDATE KT_INDICADORES SET PROCESO_ID = 2 , INDICADOR_ID = 'la vieja' , NOMBRE = 'tuql0', OBJETIVOCALIDAD_ID = 3  , OBJETIVO_ESPECÍFICO = 'comer la dona de minero' ,
                FÓRMULA_DE_CALCULO = 'dandolas' , VALOR_ACTUALIDAD = 13 , VALOR_POTENCIALIDAD = 18 , META = 19 , FRECUENCIA_MEDICION = 'mensual' , RESPONSABLE_MEDICION = 'Elias' ,
                RESPONSIBLE_SEGUIMIENTO = 'tu prima cerot3' , FUENTE_INFORMACIÓN = 'gugul' WHERE ROWID = 7 

SELECT PROCESO_ID FROM KT_PROCESOS WHERE DESCRIPCION = 'VENTAS';
SELECT OBJETIVOCALIDAD_ID FROM KT_OBJETIVOSCALIDAD WHERE PALABRA_CLAVE = 'EFICACES';
 
SELECT U.ROWID, U.USER_ID, P.DESCRIPCION, U.ROL FROM KT_USUARIOSCROSS U
JOIN KT_PROCESOS P USING( PROCESO_ID ) WHERE U.USER_ID ILIKE '%W%' OR P.DESCRIPCION ILIKE '%M%' ORDER BY U.ROWID;

SELECT ROWID, USER_ID FROM KT_USERSAPP WHERE rowid = 20;

SELECT ROWID , USER_ID , LEVEL FROM KT_USERSAPP WHERE USER_ID ILIKE'%E%' OR LEVEL ILIKE'%D%' OR ROWID = 3;

SELECT PROCESO_ID FROM KT_PROCESOS WHERE DESCRIPCION = 'DIRECCION ESTRATEGICA';

SELECT pi.ROWID, pi.PARTE_INTERESADA_ID, pr.DESCRIPCION as proceso, pi.DESCRIPCION as parte, pi.REQUISITO_IDENTIFICADO, pi.LAST_USER 
        from KT_PARTES_INTERESADAS pi join KT_PROCESOS pr USING(PROCESO_ID) where pi.PARTE_INTERESADA_ID ILIKE'%M%' OR pr.DESCRIPCION ILIKE'%M%' OR pi.DESCRIPCION ILIKE'%M%'
        OR pi.REQUISITO_IDENTIFICADO ILIKE'%M%' OR pi.LAST_USER ILIKE'%M%'
        order by ROWID
        
--------------------------------------------------------------------------ASIGNACIONES 2--------------------------------------------------------------------------

--llenado de tablas 

	insert into KT_TIPOSPARTESINTERESADAS (TIPOPI_ID, DESCRIPCION)
					values(1, 'DESCIPCION 1'),
					      (2, 'DESCIPCION 2'),
					      (3, 'DESCIPCION 3'),
					      (4, 'DESCIPCION 4'),
					      (5, 'DESCIPCION 5');
	
	insert into KT_IMPACTOS(IMPACTO_ID, TIPO, DESCRIPCION, INTENSIDAD, RGBCOLOR) values
	('1', '1', 'Leve o casi nulo', 1, '#ffebee'),
	('2', '1', 'Moderado', 2, '#ffebee'),
	('3', '1', 'Intolerable', 3, '#ffebee'),
	('4', '2', 'Leve o casi nulo', 1, '#ffebee'),
	('5', '2', 'Moderado', 2, '#ffebee'),
	('6', '2', 'Alto', 3, '#ffebee');

	insert into KT_EFICACIACONTROLES(EFICACIA_ID, DESCRIPCION, INTENSIDAD) values
	('1', 'DEFICIENTE', 1),
	('2', 'BUENO', 2),
	('3', 'SUFIENTE', 3);

	insert into KT_NIVEL_OR(NIVEL_OR_ID, TIPO, DESCRIPCION, INTENSIDAD, RGBCOLOR) values
	('1', '1', 'BAJO', 1, '#ffebee'),
	('2', '1', 'ACEPTABLE', 2, '#ffebee'),
	('3', '1', 'MODERADO', 3, '#ffebee'),
	('4', '1', 'MAYOR', 4, '#ffebee'),
	('5', '1', 'CRITICO', 6, '#ffebee'),
	('6', '1', 'INTOLERABLE', 9, '#ffebee'),
	('7', '2', 'BAJO', 1, '#ffebee'),
	('8', '2', 'ACEPTABLE', 2, '#ffebee'),
	('9', '2', 'MODERADO', 3, '#ffebee'),
	('10', '2', 'MAYOR', 4, '#ffebee'),
	('11', '2', 'BENEFICIOSO', 6, '#ffebee'),
	('12', '2', 'ALTAMENTE BENEFICIOSO', 9, '#ffebee');

	insert into KT_ELEMENTOSIMPACTO(ELEMENTOIMPACTO_ID, DESCRIPCION, INTENSIDAD) values
	('1', 'LEVE', 1),
	('2', 'MODERADO', 2),
	('3', 'CRITICO', 3);
	
	insert into KT_PROBABILIDADESOCURRENCIA(PROBABILIDAD_ID, DESCRIPCION, INTENSIDAD, RGBCOLOR) values
	('1', 'Inprobable o poco probable', 1, '#ffebee'),
	('2', 'Probable', 2, '#ffebee'),
	('3', 'Altamente probable', 3, '#ffebee');

	insert into KT_DECISIONES_OR(DECISION_OR_ID, TIPO, DESCRIPCION, NIVEL, RGBCOLOR) values
	('1', '1', 'NINGUNA ACCION (SE ASUME EL RIESGO)', 1, '#ffebee'),
	('2', '1', 'REVISION DE LOS CONTROLES QUE SE TIENEN IMPLEMENTADOS Y ASUMIR EL RIESGO', 2, '#ffebee'),
	('3', '1', 'BUSCAR UNA SOLUCION DE MEJORA EN LOS CONTROLES ACTUALES', 3, '#ffebee'),
	('4', '1', 'DISEÑAR Y PLANIFICAR EN EL MEDIANO PLAZO NUEVOS CONTROLES', 4, '#ffebee'),
	('5', '1', 'DISEÑAR Y PLANIFICAR EN EL CORTO PLAZO NUEVOS CONTROLES O ACCIONES', 6, '#ffebee'),
	('6', '1', 'DISEÑAR Y EJECUTAR DE INMEDIATO NUEVOS CONTROLES O ACCIONES', 9, '#ffebee'),
	('7', '2', 'NINGUNA ACCION', 1, '#ffebee'),
	('8', '2', 'NINGUNA ACCION', 2, '#ffebee'),
	('9', '2', 'PLANIFICAR ACCIONES DE MEJORA A MEDIANO PLAZO', 3, '#ffebee'),
	('10', '2', 'PLANIFICAR ACCIONES DE MEJORA A MEDIANO PLAZO', 4, '#ffebee'),
	('11', '2', 'DISEÑAR Y PLANIFICAR EN EL CORTO PLAZO ACCIONES PARA APROBECHAR LAS OPORTUNIDADES', 6, '#ffebee'),
	('12', '2', 'DISEÑAR Y PLANIFICAR EN EL CORTO PLAZO ACCIONES PARA APROBECHAR LAS OPORTUNIDADES', 9, '#ffebee');
	
	insert into KT_FACTIBILIDAD(FACTIBILIDAD_ID, DESCRIPCION, INTENSIDAD, RGBCOLOR) values
	('1', 'Inprobable o poco probable', 1, '#ffebee'),
	('2', 'Probable', 2, '#ffebee'),
	('3', 'Altamente probable', 3, '#ffebee');

	insert into KT_TIPOSMATRIZ(TIPOMATRIZ_ID, DESCRIPCION, CLASIFICACION) values
	('1', 'RIESGO','1'),
	('2', 'OPORTUNIDAD','2');

	insert into KT_PROCESOS(PROCESO_ID, DESCRIPCION) values
	('1', 'GARANTIA DE CALIDAD'),
	('2', 'PRODUCCION'),
	('3', 'MERCADEO Y VENTAS'),
	('4', 'INVESTIGACION Y DESARROLLO'),
	('5', 'LOGISTICA'),
	('6', 'MANTENIMIENTO'),
	('7', 'CAPITAL HUMANO'),
	('8', 'COMPRAS'),
	('9', 'CONTROL DE CALIDAD'),
	('10', 'CREDITOS Y COBROS'),
	('11', 'TECNOLOGIAS DE LA INFORMACION'),
	('12', 'DIRECCION ESTRATEGICA');

	insert into KT_CORRELATIVOS(PROCESO_ID, CORRELATIVO_ID, ULTIMO_NUM_UTILIZADO)
		values( 1, '6' ,1),
		      ( 2, '7',2),
		      ( 3, '8',3),
		      ( 4, '9',4),
		      ( 5, '10',1);

	select*from kt_correlativos;
	
	insert into KT_OBJETIVOSCALIDAD(OBJETIVOCALIDAD_ID, DESCRIPCION, PALABRA_CLAVE) values
	('1', 'Lograr el cumplimiento de los estándares establecidos por las regulaciones internacionales.', 'ESTANDARES INTERNACIONALES'),
	('2', 'Mantener y mejorar el cumplimiento de las especificaciones del cliente y normas de calidad establecidas para la I. farmaceutica.', 'CALIDAD'),
	('3', 'Lograr los resultados esperados en los procesos.', 'EFICACES'),
	('4', 'Brindar la confianza de hacer las cosas bien desde la primera vez.', 'SEGUROS'),
	('5', 'Buscar e implmentar oportunidades para lograr la eficiencia.', 'MEJORA CONTINUA');

	insert into KT_INDICADORES(PROCESO_ID, INDICADOR_ID, NOMBRE, OBJETIVOCALIDAD_ID, OBJETIVO_ESPECÍFICO, FÓRMULA_DE_CALCULO, VALOR_ACTUALIDAD, VALOR_POTENCIALIDAD, META, FRECUENCIA_MEDICION, RESPONSABLE_MEDICION, RESPONSIBLE_SEGUIMIENTO, FUENTE_INFORMACIÓN) values
	('1', 'RafaGhay', 'Efectividad en la atención de incidentes.', '3', 'Garantizar la resolución oportuna de los incidentes de los usuarios', 'Cantidad de incidentes resueltos / Cantidad de Incidentes reportados en la mesa de ayuda Focus CAN que no requieren inversión.', '99.61%', '100%', '99.75%', 'Mensual', 'Coordinador de Servicios de TI', 'Gerente de Tecnologías de la Información.', 'Reporte de Mesa de Ayuda.');

	insert into KT_PARTES_INTERESADAS(PROCESO_ID, PARTE_INTERESADA_ID, DESCRIPCION, REQUISITO_IDENTIFICADO, LAST_USER) values
	('11', '1', 'Proveedores de bienes y servicios de Tecnologías de Información y Comunicación', 'Facturas y/o Contrato de Servicios autorizados', 'carlos.rodriguez'),
	('11', '2', 'Usuarios de Red de Computadoras', 'Productos y/o Servicios Informáticos solicitados e ingresados en la ventana de requerimientos informáticos, entregas a tiempo y que cumplan con las especificaciones y/o lo requerido', 'carlos.rodriguez'),
	('11', '3', 'Compras', 'Especificaciones Técnicas para adquisición de Productos y servicios', 'carlos.rodriguez');

	insert into KT_USERSAPP(USER_ID, PASSWORD, LEVEL) values
	('Holi1','Holi1','T'),
	('Holi2','Holi2','D'),
	('Holi3','Holi3','T'),
	('Holi4','Holi4','C'),
	('Holi5','Holi5','D'),
	('Elian Cortez', 'cocos', 'D'),
	('Guillermo Minero', 'pollo', 'T'),
	('Bryan Cruz', 'agua', 'R'),
	('Wilmer Carrillo', 'jugo', 'A'),
	('Carlos Rodriguez', 'hielo', 'C');

	insert into KT_USUARIOSCROSS(USER_ID, PROCESO_ID, ROL) values
	('Elian Cortez', '1', 1),
	('Guillermo Minero', '1', 2),
	('Bryan Cruz', '2', 2),
	('Wilmer Carrillo', '2', 3),
	('Carlos Rodriguez', '11', 1);

	insert into MATRICES(MATRIZ_ID, TIPOMATRIZ_ID, OBJETIVOCALIDAD_ID, PROCESO_ID, INDICADOR_ID, PARTE_INTERESADA_ID, PROCESO_ELEMENTO, CLASIFICACION_MATRIZ, RO_NUM, EDICION_NUM, STATUS, ENTRADA, ACTIVIDAD, SALIDA, OPORTUNIDAD, RIESGO, ETAPA, MERCADO_E_IMAGEN, AFECTACION_RECURSOS, CUMPLIMIENTO_REQUISITOS, MEDIO_AMBIENTE, RESPONSABILIDAD_SOCIAL, SEGURIDAD, CONSECUENCIA, CONTROLES_EXISTENTES, EFICACIA_ID, CAUSA, FACTIBILIDAD_ID, IMPACTO_ID, RESULTADO, NIVEL_OR_ID, DECISION_OR_ID, PROBABILIDAD_ID, LAST_USER) values
	('1', '1', '1', '11', '1', '1', 'Elementos a utilizar', '1', 1, 1, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '1', 'Descripcion de la causa del OR', '1', '1', 'resultado proximo', '1', '1', '1', 'Elian Cortez'),
	('2', '1', '2', '11', '1', '2', 'Elementos a utilizar', '1', 2, 2, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '2', 'Descripcion de la causa del OR', '2', '2', 'resultado proximo', '2', '2', '2', 'Elian Cortez'),
	('3', '1', '3', '11', '1', '3', 'Elementos a utilizar', '1', 1, 3, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '3', 'Descripcion de la causa del OR', '3', '3', 'resultado proximo', '3', '3', '3', 'Elian Cortez'),
	('4', '1', '4', '11', '1', '1', 'Elementos a utilizar', '1', 2, 4, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '1', 'Descripcion de la causa del OR', '1', '1', 'resultado proximo', '4', '4', '1', 'Elian Cortez'),
	('5', '1', '5', '11', '1', '2', 'Elementos a utilizar', '1', 1, 5, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '2', 'Descripcion de la causa del OR', '2', '2', 'resultado proximo', '5', '5', '2', 'Elian Cortez'),
	('6', '1', '1', '11', '1', '3', 'Elementos a utilizar', '1', 2, 6, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '3', 'Descripcion de la causa del OR', '3', '3', 'resultado proximo', '6', '6', '3', 'Elian Cortez'),
	('7', '1', '1', '11', '1', '1', 'Elementos a utilizar', '1', 1, 7, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '1', 'Descripcion de la causa del OR', '1', '1', 'resultado proximo', '1', '1', '1', 'Elian Cortez'),
	('8', '1', '2', '11', '1', '2', 'Elementos a utilizar', '1', 2, 8, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '2', 'Descripcion de la causa del OR', '2', '2', 'resultado proximo', '2', '2', '2', 'Guillermo Minero'),
	('9', '1', '3', '11', '1', '3', 'Elementos a utilizar', '1', 1, 9, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '3', 'Descripcion de la causa del OR', '3', '3', 'resultado proximo', '3', '3', '3', 'Guillermo Minero'),
	('10', '1', '4', '11', '1', '1', 'Elementos a utilizar', '1', 2, 1, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '1', 'Descripcion de la causa del OR', '1', '1', 'resultado proximo', '4', '4', '1', 'Guillermo Minero'),
	('11', '1', '5', '11', '1', '2', 'Elementos a utilizar', '1', 1, 2, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '2', 'Descripcion de la causa del OR', '2', '2', 'resultado proximo', '5', '5', '2', 'Guillermo Minero'),
	('12', '1', '1', '11', '1', '3', 'Elementos a utilizar', '1', 2, 3, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '3', 'Descripcion de la causa del OR', '3', '3', 'resultado proximo', '6', '6', '3', 'Guillermo Minero'),
	('13', '1', '1', '11', '1', '1', 'Elementos a utilizar', '1', 1, 4, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '1', 'Descripcion de la causa del OR', '1', '1', 'resultado proximo', '1', '1', '1', 'Guillermo Minero'),
	('14', '1', '2', '11', '1', '2', 'Elementos a utilizar', '1', 2, 5, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '2', 'Descripcion de la causa del OR', '2', '2', 'resultado proximo', '2', '2', '2', 'Guillermo Minero'),
	('15', '1', '3', '11', '1', '3', 'Elementos a utilizar', '1', 1, 6, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '3', 'Descripcion de la causa del OR', '3', '3', 'resultado proximo', '3', '3', '3', 'Bryan Cruz'),
	('16', '2', '4', '11', '1', '1', 'Elementos a utilizar', '2', 2, 7, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '1', 'Descripcion de la causa del OR', '1', '4', 'resultado proximo', '7', '7', '1', 'Bryan Cruz'),
	('17', '2', '5', '11', '1', '2', 'Elementos a utilizar', '2', 1, 8, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '2', 'Descripcion de la causa del OR', '2', '5', 'resultado proximo', '8', '8', '2', 'Bryan Cruz'),
	('18', '2', '1', '11', '1', '3', 'Elementos a utilizar', '2', 2, 9, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '3', 'Descripcion de la causa del OR', '3', '6', 'resultado proximo', '9', '9', '3', 'Bryan Cruz'),
	('19', '2', '1', '11', '1', '1', 'Elementos a utilizar', '2', 1, 1, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '1', 'Descripcion de la causa del OR', '1', '4', 'resultado proximo', '10', '10', '1', 'Bryan Cruz'),
	('20', '2', '2', '11', '1', '2', 'Elementos a utilizar', '2', 2, 2, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '2', 'Descripcion de la causa del OR', '2', '5', 'resultado proximo', '11', '11', '2', 'Bryan Cruz'),
	('21', '2', '3', '11', '1', '3', 'Elementos a utilizar', '2', 1, 3, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '3', 'Descripcion de la causa del OR', '3', '6', 'resultado proximo', '12', '12', '3', 'Bryan Cruz'),
	('22', '2', '4', '11', '1', '1', 'Elementos a utilizar', '2', 2, 4, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '1', 'Descripcion de la causa del OR', '1', '4', 'resultado proximo', '7', '7', '1', 'Wilmer Carrillo'),
	('23', '2', '5', '11', '1', '2', 'Elementos a utilizar', '2', 1, 5, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '2', 'Descripcion de la causa del OR', '2', '5', 'resultado proximo', '8', '8', '2', 'Wilmer Carrillo'),
	('24', '2', '1', '11', '1', '3', 'Elementos a utilizar', '2', 2, 6, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '3', 'Descripcion de la causa del OR', '3', '6', 'resultado proximo', '9', '9', '3', 'Wilmer Carrillo'),
	('25', '2', '1', '11', '1', '1', 'Elementos a utilizar', '2', 1, 7, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '1', 'Descripcion de la causa del OR', '1', '4', 'resultado proximo', '10', '10', '1', 'Wilmer Carrillo'),
	('26', '2', '2', '11', '1', '2', 'Elementos a utilizar', '2', 2, 8, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '2', 'Descripcion de la causa del OR', '2', '5', 'resultado proximo', '11', '11', '2', 'Wilmer Carrillo'),
	('27', '2', '3', '11', '1', '3', 'Elementos a utilizar', '2', 1, 9, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '3', 'Descripcion de la causa del OR', '3', '6', 'resultado proximo', '12', '12', '3', 'Wilmer Carrillo'),
	('28', '2', '4', '11', '1', '1', 'Elementos a utilizar', '2', 2, 1, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '1', 'Descripcion de la causa del OR', '1', '4', 'resultado proximo', '7', '7', '1', 'Wilmer Carrillo'),
	('29', '2', '5', '11', '1', '2', 'Elementos a utilizar', '2', 1, 2, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '2', 'Descripcion de la causa del OR', '2', '5', 'resultado proximo', '8', '8', '2', 'Carlos Rodriguez'),
	('30', '2', '1', '11', '1', '3', 'Elementos a utilizar', '2', 2, 3, 'REVISION', 'Informacion de entrada', 'Actividad de OR', 'Informacion de salidad', 'Descripicon de oportunidad', 'Descripcion de Riesgo', 'Etapa?', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'LEVE', 'Concecuenias de respectivo OR', 'Descripcion de controles existentes en la actualidad', '3', 'Descripcion de la causa del OR', '3', '6', 'resultado proximo', '9', '9', '3', 'Carlos Rodriguez');

	insert into MATRICES_ACCIONES(MATRIZ_ID, PROCESO_ELEMENTO, EDICION_NUM, ACCION_NUM, ACCION_PROPUESTA, RESPONSABLE_ACCION, CARGO_RESPONSABLE, RECURSOS_REQUERIDOS, REQUIERE_AUT, FECHA_PLANEADA, FECHA_EJECUTADA, FECHA_SEGUIMIENTO, RESPONSABLE_SEGUIMIENTO, CARGO_SEGUIMIENTO, RESULTADO_SEGUIMIENTO, NIVEL_REDUCIDO_PROBABILIDAD_ID, NIVEL_REDUCIDO_IMPACTO_ID, NIVEL_REDUCIDO_RIESGO_ID, REQUIERE_AC, REFERENCIA_AC, LAST_USER, CTRL_CIERRE_AC, FECHA_CIERRE_AC, ESTADO_ACCION, EVIDENCIAS) values
	('1', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Germam Flores', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-15', '2020-05-15', '2020-05-15', 'Fernando Garmendia', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Elian Cortez', '1', '2020-05-15', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('2', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Germam Flores', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-15', '2020-05-15', '2020-05-15', 'Fernando Garmendia', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Elian Cortez', '1', '2020-05-15', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('3', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Germam Flores', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-15', '2020-05-15', '2020-05-15', 'Fernando Garmendia', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Elian Cortez', '1', '2020-05-15', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('4', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Germam Flores', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-15', '2020-05-15', '2020-05-15', 'Fernando Garmendia', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Elian Cortez', '1', '2020-05-15', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('5', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Germam Flores', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-15', '2020-05-15', '2020-05-15', 'Fernando Garmendia', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Elian Cortez', '1', '2020-05-15', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('6', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Germam Flores', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-16', '2020-05-16', '2020-05-16', 'Fernando Garmendia', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Elian Cortez', '1', '2020-05-16', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('7', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Germam Flores', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-16', '2020-05-16', '2020-05-16', 'Fernando Garmendia', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Elian Cortez', '1', '2020-05-16', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('8', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Pablo Rios', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-16', '2020-05-16', '2020-05-16', 'Miguel Marino', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Guillermo Minero', '1', '2020-05-16', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('9', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Pablo Rios', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-16', '2020-05-16', '2020-05-16', 'Miguel Marino', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Guillermo Minero', '1', '2020-05-16', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('10', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Pablo Rios', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-16', '2020-05-16', '2020-05-16', 'Miguel Marino', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Guillermo Minero', '1', '2020-05-16', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('11', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Pablo Rios', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-17', '2020-05-17', '2020-05-17', 'Miguel Marino', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Guillermo Minero', '1', '2020-05-17', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('12', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Pablo Rios', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-17', '2020-05-17', '2020-05-17', 'Miguel Marino', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Guillermo Minero', '1', '2020-05-17', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('13', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Pablo Rios', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-17', '2020-05-17', '2020-05-17', 'Miguel Marino', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Guillermo Minero', '1', '2020-05-17', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('14', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Pablo Rios', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-17', '2020-05-17', '2020-05-17', 'Miguel Marino', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Guillermo Minero', '1', '2020-05-17', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('15', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Kevin Plata', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-17', '2020-05-17', '2020-05-17', 'Ricardo Muelles', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Bryan Cruz', '1', '2020-05-17', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('16', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Kevin Plata', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-18', '2020-05-18', '2020-05-18', 'Ricardo Muelles', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Bryan Cruz', '1', '2020-05-18', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('17', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Kevin Plata', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-18', '2020-05-18', '2020-05-18', 'Ricardo Muelles', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Bryan Cruz', '1', '2020-05-18', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('18', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Kevin Plata', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-18', '2020-05-18', '2020-05-18', 'Ricardo Muelles', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Bryan Cruz', '1', '2020-05-18', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('19', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Kevin Plata', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-18', '2020-05-18', '2020-05-18', 'Ricardo Muelles', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Bryan Cruz', '1', '2020-05-18', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('20', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Kevin Plata', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-18', '2020-05-18', '2020-05-18', 'Ricardo Muelles', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Bryan Cruz', '1', '2020-05-18', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('21', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Kevin Plata', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-19', '2020-05-19', '2020-05-19', 'Ricardo Muelles', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Bryan Cruz', '1', '2020-05-19', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('22', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Germam Flores', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-19', '2020-05-19', '2020-05-19', 'Fernando Garmendia', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Wilmer Carrillo', '1', '2020-05-19', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('23', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Germam Flores', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-19', '2020-05-19', '2020-05-19', 'Fernando Garmendia', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Wilmer Carrillo', '1', '2020-05-19', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('24', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Germam Flores', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-19', '2020-05-19', '2020-05-19', 'Fernando Garmendia', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Wilmer Carrillo', '1', '2020-05-19', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('25', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Pablo Rios', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-19', '2020-05-19', '2020-05-19', 'Miguel Marino', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Wilmer Carrillo', '1', '2020-05-19', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('26', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Pablo Rios', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-20', '2020-05-20', '2020-05-20', 'Miguel Marino', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Wilmer Carrillo', '1', '2020-05-20', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('27', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Pablo Rios', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-20', '2020-05-20', '2020-05-20', 'Miguel Marino', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Wilmer Carrillo', '1', '2020-05-20', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('28', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Kevin Plata', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-20', '2020-05-20', '2020-05-20', 'Ricardo Muelles', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Wilmer Carrillo', '1', '2020-05-20', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('29', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Kevin Plata', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-20', '2020-05-20', '2020-05-20', 'Ricardo Muelles', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Carlos Rodriguez', '1', '2020-05-20', 'Proxima', 'Evidencia de la realisacion de la accion'),
	('30', 'Elementos a utilizar', 1, 1, 'Propuesta de accion ante OR', 'Kevin Plata', 'Gerente', 'Recursos a utilizar', 'aut requiere', '2020-05-20', '2020-05-20', '2020-05-20', 'Ricardo Muelles', 'Supervisor', 'Buen resultado', '1', '1', '1', '1', 'Referencia añadida', 'Carlos Rodriguez', '1', '2020-05-20', 'Proxima', 'Evidencia de la realisacion de la accion');
	
		     

--consultas update



--Actualizando un proceso cuando sea el primero ingresado
update KT_PROCESOS set DESCRIPCION='VENTAS' where PROCESO_ID=(select min(PROCESO_ID) from KT_PROCESOS);

--Actualizando el proceso de un correlativo cuando su id de correlativo sea el requerido
update KT_CORRELATIVOS set ULTIMO_NUM_UTILIZADO=2 where PROCESO_ID='3';

--Actualizando la descripción de una decision cuando sea la ultima ingresada
update KT_DECISIONES_OR set DESCRIPCION='Descripcion modificada por factores externos' where DECISION_OR_ID=(select max(DECISION_OR_ID) from KT_DECISIONES_OR);

--Actualizando la intensidad de un control de eficacia cuando su id sea el ultimo ingresado
update KT_EFICACIACONTROLES set INTENSIDAD=2 where ROWID=(select max(ROWID) from KT_EFICACIACONTROLES);

--Actualizando la descripción de un elemento de impacto cuando su id sea el primero ingresado
update KT_ELEMENTOSIMPACTO set DESCRIPCION='Descripcion modificada por factores externos' where ROWID=(select min(ROWID) from KT_ELEMENTOSIMPACTO);




--funciones de agregación



--mostrando los procesos en orden descendente
select*from KT_PROCESOS order by PROCESO_ID desc;

--mostrando los procesos en orden ascendente
select*from KT_PROCESOS order by PROCESO_ID desc;

--mostrando la descripcion de un proceso cuando sea el ultimo ingresado y agrupandolo por DESCRIPCION
select max(ROWID)máximo_ingresado, DESCRIPCION from KT_PROCESOS group by  DESCRIPCION;

--mostrando los correlativos con su proceso cuyo ultimo número utilizado esté entre 1 a 3
select P.PROCESO_ID, P.DESCRIPCION, C.CORRELATIVO_ID, C.ULTIMO_NUM_UTILIZADO from KT_PROCESOS P 
inner join KT_CORRELATIVOS C on P.PROCESO_ID = C.PROCESO_ID where ULTIMO_NUM_UTILIZADO between 1 and 3;

--mostrando los correlativos con su proceso cuyo ultimo número utilizado no esté entre 1 a 3
select P.PROCESO_ID, P.DESCRIPCION, C.CORRELATIVO_ID, C.ULTIMO_NUM_UTILIZADO from KT_PROCESOS P 
inner join KT_CORRELATIVOS C on P.PROCESO_ID = C.PROCESO_ID where ULTIMO_NUM_UTILIZADO not between 1 and 3;

--mostrando la suma de los ultimos numeros utilizados de los correlativos
select sum(ULTIMO_NUM_UTILIZADO)suma_numeros_utilizados from  KT_CORRELATIVOS;

--mostrando el valor menor de ultimos numeros utilizados de los correlativos
select min(ULTIMO_NUM_UTILIZADO)menor_ultimo_numero_utilizado from  KT_CORRELATIVOS;

--mostrando el valor mayor de ultimos numeros utilizados de los correlativos
select max(ULTIMO_NUM_UTILIZADO)mayor_ultimo_numero_utilizado from  KT_CORRELATIVOS;

--mostrando el promedio de ultimos numeros utilizados de los correlativos
select avg(ULTIMO_NUM_UTILIZADO)promedio_ultimos_numeros_utilizados from  KT_CORRELATIVOS;

--mostrando cuantos usuarios hay ingresados, cuantos hay por id y cuantos son diferentes
select count(*)usuarios_ingresados, count(USER_ID)ingresados_por_id, count(distinct USER_ID)usuarios_diferentes from  KT_USERSAPP;




--tipos de joins



--cross join de tabla KT_PROCESOS con KT_CORRELATIVOS
select * from KT_PROCESOS cross join  KT_CORRELATIVOS;

--inner join de tabla KT_PROCESOS con KT_CORRELATIVOS
select * from KT_PROCESOS P
inner join  KT_CORRELATIVOS C on P.PROCESO_ID = C.PROCESO_ID;

--left outer join de tabla KT_PROCESOS con KT_CORRELATIVOS
select* from KT_PROCESOS P
left join KT_CORRELATIVOS C on P.PROCESO_ID = C.PROCESO_ID;

--right outer join de tabla KT_PROCESOS con KT_CORRELATIVOS
select* from KT_CORRELATIVOS C
right join KT_PROCESOS P on P.PROCESO_ID = C.PROCESO_ID;

--full outer join de tabla KT_PROCESOS con KT_CORRELATIVOS
select * from KT_PROCESOS P
full join  KT_CORRELATIVOS C on P.PROCESO_ID = C.PROCESO_ID;

--full outer join de tabla KT_PROCESOS con KT_CORRELATIVOS que muestra los correlativos que no estan usando procesos
select * from KT_PROCESOS P
full join  KT_CORRELATIVOS C on P.PROCESO_ID = C.PROCESO_ID
where P.PROCESO_ID is null or C.PROCESO_ID is null;


--funciones



--creando una vista de la tabla KT_PROCESOS con KT_CORRELATIVOS
create view PROCESOS_CORRELATIVOS
as
select P.PROCESO_ID, P.DESCRIPCION, C.CORRELATIVO_ID, C.ULTIMO_NUM_UTILIZADO from KT_PROCESOS P, KT_CORRELATIVOS C where P.PROCESO_ID = C.PROCESO_ID;

select*from PROCESOS_CORRELATIVOS;

--creando una funcion que me muestre un proceso de la tabla KT_PROCESOS recibiendo por parametro un número para ultimo numero utilizado de tabla KT_CORRELATIVOS
create or replace function PROCESO(numero int)
returns setof record
as $$      
select P.PROCESO_ID FROM KT_PROCESOS P 
	inner join KT_CORRELATIVOS C ON P.PROCESO_ID = C.PROCESO_ID where C.ULTIMO_NUM_UTILIZADO = numero;
$$
language sql;

select PROCESO(2);

--creando un procedimiento que inserte en la tabla KT_PROCESOS (postgres no permite el uso de procedimientos, por lo que se usan funciones que cumplen la misma funcionalidad)
create or replace function insertar_proceso(proceso_id integer, descripcion varchar(128))
returns void as
$$
	insert into KT_PROCESOS (PROCESO_ID, DESCRIPCION) values (proceso_id, descripcion)
$$
language sql;

select insertar_proceso(13, 'DESCRIPCION DE OTRO PROCESO');

--creando un trigger
--creando una tabla historial para la parte de procesos
create table KT_HISTORIAL(
HISTORIAL_ID serial primary key,
ACCION varchar(50),
FECHA date
);

--creando una funcion que insertara en la tabla KT_HISTORIAL
create function INSERCION_PROCESO() 
returns trigger
as
$$
     declare
     ACCION varchar(40);
begin
insert into KT_HISTORIAL(ACCION, FECHA) values('se ha agregado un proceso', current_date);
return new;
end
$$
language plpgsql;

--creando un trigger que ejecutara la funcion INSERCION_PROCESO() luego de insertar en la tabla KT_PROCESOS
create trigger LLENAR_HISTORIAL after insert on KT_PROCESOS
for each row
execute procedure INSERCION_PROCESO();

--se inserta un proceso en la tabla KT_PROCESOS
insert into KT_PROCESOS (PROCESO_ID, DESCRIPCION) values(20, 'Descripción del nuevo proceso');

--se consulta la tabla KT_HISTORIAL para verificar que el trigger funciona
select*from KT_HISTORIAL;




--------------------------------------------------------------------------ASIGNACIONES 3--------------------------------------------------------------------------

--consultas para reportes

--consulta que muestra los correlativos con sus procesos cuando la descripcion deprocesos no empiecen con C
select*from KT_PROCESOS P
inner join KT_CORRELATIVOS C on P.PROCESO_ID = C.PROCESO_ID where P.DESCRIPCION not like'C%';

--consulta que muestra las partes interesadas con sus procesos cuando el id de parte interesada este entre 1 y 2
select*from KT_PARTES_INTERESADAS PI
inner join KT_PROCESOS P on PI.PROCESO_ID = P.PROCESO_ID where PI.PARTE_INTERESADA_ID between '1' and '2';

--consulta que muestra los usuarios con un nivel entre A y D
select*from KT_USERSAPP where level between 'A' and 'D' order by USER_ID ASC;

--consulta que muestra los objetivos de calidad que no tengan como palabra clave CALIDAD
select*from KT_OBJETIVOSCALIDAD where PALABRA_CLAVE not in ('CALIDAD') order by DESCRIPCION ASC;

--consulta que muestra los niveles cuando su intensidad este entre 2 y 5
select * from KT_NIVEL_OR where INTENSIDAD between '2' and '5' order by DESCRIPCION ASC;



--consultas para reportes con rango de fechas

--consulta que muestra las acciones de una matriz cuando su fecha planeada esté entre 2020-05-10 y 2020-05-15
select*from MATRICES_ACCIONES where FECHA_PLANEADA between '2020-05-10' and '2020-05-15';

--consulta que muestra las acciones de una matriz cuando su fecha ejecutada no esté entre 2020-05-10 y 2020-05-15
select*from MATRICES_ACCIONES where FECHA_EJECUTADA not between '2020-05-10' and '2020-05-15';

--si la tabla KT_HISTORIAL fue creada para el trigger, mostrar las acciones que esten entre la fecha 2020-05-1 y 2020-05-09
select*from KT_HISTORIAL where FECHA between '2020-05-1' and '2020-05-09';



--consultas patra gráficos

--consulta que muestra los correlativos con sus procesos
select*from KT_PROCESOS P
inner join KT_CORRELATIVOS C on P.PROCESO_ID = C.PROCESO_ID;

--consulta que muestra las partes interesadas con sus procesos
select*from KT_PARTES_INTERESADAS PI
inner join KT_PROCESOS P on PI.PROCESO_ID = P.PROCESO_ID;

--consulta que muestra las matrices con sus objetivos de calidad
select*from MATRICES M
inner join KT_OBJETIVOSCALIDAD OC on M.OBJETIVOCALIDAD_ID = OC.OBJETIVOCALIDAD_ID;

--consulta que muestra las matrices con sus procesos
select*from MATRICES M
inner join KT_PROCESOS P on M.PROCESO_ID = P.PROCESO_ID;

--consulta que muestra las matrices con sus partes interesadas
select*from MATRICES M
inner join KT_PARTES_INTERESADAS PI on M.PARTE_INTERESADA_ID = PI.PARTE_INTERESADA_ID;



--generación de back up

--para accerder a la ruta de carpeta bin de postgres--
cd C:\Program Files (x86)\PostgreSQL\9.3\bin
--comando para generar el back up(luego de haber accedido en la ruta anterior se copia lo siguiente)
pg_dump -U postgres -C -f C:\Users\Public\RespaldoBaseExpo.dump BaseExpo_#20180695_#20180296_#20180385_#20180521

--borrando la base de datos luego de hacer el back up(en consola psql)--

--Database [postgres]: se ingresa el nombre de la base
--Username [postgres]: nombre del usuario
--luego pedirá la contraseña y si se ingresa correctamente se conectara con nuestra base
--luego se ingresa lo siguiente para conectarse con la base de datos postgres
\c postgres
--luego se borra la base si no esta siendo utilizada por nadie(tuve que cerrar pgadmin para poder borrarla)
drop database "BaseExpo_#20180695_#20180296_#20180385_#20180521";

--para recuperar la base de datos--
--en consola de windows se dirige a esta dirección si no lo está
cd C:\Program Files (x86)\PostgreSQL\9.3\bin
--luego en consola de windows se pone lo siguiente--
psql -U postgres < C:\Users\Public\RespaldoBaseExpo.dump
--se ingresa la contraseña del usuario de postgres y se espera a que se termine de restaurar
--luego se conecta a la base en la consola psql con
\c BaseExpo_#20180695_#20180296_#20180385_#20180521



--tarea programada
--se revisa que los archivos de pgpass esten bien configurados, para ello se busca en el explorador de archivos en este equipo poniendo pgpass para buscarlos
--se crea un archivo.bat con lo siguiente:
@echo off
SET PG_BIN="C:\Program Files (x86)\PostgreSQL\9.3\bin\pg_dump.exe"
SET PG_HOST=localhost
SET PG_PORT=5432
SET PG_DATABASE=nombre de la base de datos (BaseExpo_#20180695_#20180296_#20180385_#20180521)
SET PG_USER=usuario de postgres
SET PGPASSWORD= contraseña del usuario de postgres
SET PG_PATH =C:\dataPostgreSQL\BackUps
SET FECHAYHORA = %date:/=%%time:~0,8%
SET FECHAYHORA = %FECHAYHORA: =-%
SET FECHAYHORA = %FECHAYHORA: =0%
SET PG_FILENAME = %PG_PATH%\%PG_DATABASE%-%FECHAYHORA%.sql
%PG_BIN% -I -H %PG_HOST% -p %PG_PORT% -U %PG_USER% %PG_DATABASE% > %PG_FILENAME%

-- se crea una tarea programada con el programador de tareas de windows
--se configura la tarea usando la ruta donde está el script y se le asignan detalles como el periodo de tiempo que se ejecutaran, acciones(acá se especifica la ubicacion del archivo.bat), condiciones, etc
-- luego se verifica que se ejecuto la tarea programada

SELECT P.DESCRIPCION, C.CORRELATIVO_ID, C.ULTIMO_NUM_UTILIZADO FROM KT_CORRELATIVOS C
INNER JOIN KT_PROCESOS P ON C.PROCESO_ID = P.PROCESO_ID;

SELECT P.DESCRIPCION, C.CORRELATIVO_ID, C.ULTIMO_NUM_UTILIZADO
                FROM KT_PROCESOS P INNER JOIN KT_CORRELATIVOS C
                ON P.PROCESO_ID = C.PROCESO_ID
                WHERE P.DESCRIPCION ILIKE '%v%' OR C.CORRELATIVO_ID ILIKE '%3%';


SELECT * FROM KT_PROCESOS;
SELECT * FROM KT_USUARIOSCROSS;


/*Para reporte de los usuarios por rol pertenecientes a un proceso*/
SELECT DESCRIPCION FROM KT_PROCESOS WHERE PROCESO_ID = '2'
SELECT DISTINCT(ROL) FROM KT_USUARIOSCROSS WHERE PROCESO_ID = '2' ORDER BY ROL;
SELECT U.USER_ID FROM KT_USUARIOSCROSS U WHERE U.PROCESO_ID = '2' AND ROL = 2;

/*Para reporte de los usuarios pertenecientes a un proceso*/
SELECT DESCRIPCION FROM KT_PROCESOS WHERE PROCESO_ID = '2'
SELECT USER_ID , ROL FROM KT_USUARIOSCROSS WHERE PROCESO_ID = '2';

/*Para reporte de correlativos, según el id del proceso*/
SELECT CORRELATIVO_ID , ULTIMO_NUM_UTILIZADO FROM KT_CORRELATIVOS where proceso_id = '2';

/*Para reporte de indicadores según proceso*/
SELECT I.INDICADOR_ID, I.NOMBRE, O.PALABRA_CLAVE, I.OBJETIVO_ESPECÍFICO FROM KT_INDICADORES I
JOIN KT_OBJETIVOSCALIDAD O USING(OBJETIVOCALIDAD_ID) where proceso_id = '2';

/*Para reporte de partes interesadas según el id del proceso*/
SELECT PARTE_INTERESADA_ID , DESCRIPCION , REQUISITO_IDENTIFICADO FROM KT_PARTES_INTERESADAS WHERE PROCESO_ID = '1';

/*Para reporte de indicadores por objetivo de calidad*/
SELECT PALABRA_CLAVE FROM KT_OBJETIVOSCALIDAD WHERE OBJETIVOCALIDAD_ID = '3';
SELECT DISTINCT(DESCRIPCION) FROM KT_INDICADORES I
JOIN KT_PROCESOS P USING(PROCESO_ID)
where OBJETIVOCALIDAD_ID = '3';
SELECT I.INDICADOR_ID, I.NOMBRE, O.PALABRA_CLAVE, I.OBJETIVO_ESPECÍFICO FROM KT_INDICADORES I
JOIN KT_OBJETIVOSCALIDAD O USING(OBJETIVOCALIDAD_ID) where objetivocalidad_id = '3';

/*Para gráfico de usuarios pertenecientes a un proceso y con un rol distinto*/
SELECT COUNT(U.ROL)AS usuarios, U.ROL, P.DESCRIPCION FROM KT_USUARIOSCROSS U 
JOIN KT_PROCESOS P USING(PROCESO_ID)
WHERE U.PROCESO_ID = '2' GROUP BY P.DESCRIPCION, ROL;

/*Para gráfico de correlativos según proceso*/
SELECT COUNT(DISTINCT(C.CORRELATIVO_ID)), C.ULTIMO_NUM_UTILIZADO, P.DESCRIPCION FROM KT_CORRELATIVOS C
JOIN KT_PROCESOS P USING(PROCESO_ID) WHERE C.PROCESO_ID = '3' GROUP BY C.CORRELATIVO_ID , C.ULTIMO_NUM_UTILIZADO , P.DESCRIPCION;

/*Para gráfico de indicadores según proceso*/
SELECT COUNT(I.INDICADOR_ID) as cantidad , P.DESCRIPCION FROM KT_INDICADORES I
JOIN KT_PROCESOS P USING(PROCESO_ID) WHERE I.PROCESO_ID = '9' GROUP BY P.DESCRIPCION;

SELECT COUNT(I.INDICADOR_ID) as cantidadindicadores, P.DESCRIPCION, O.PALABRA_CLAVE FROM KT_INDICADORES I
JOIN KT_OBJETIVOSCALIDAD O USING(OBJETIVOCALIDAD_ID)
JOIN KT_PROCESOS P USING(PROCESO_ID)
WHERE I.OBJETIVOCALIDAD_ID = '3' GROUP BY P.DESCRIPCION, O.PALABRA_CLAVE;

SELECT * FROM KT_PROCESOS;
SELECT* FROM KT_CORRELATIVOS
SELECT * FROM KT_INDICADORES;
SELECT * FROM KT_OBJETIVOSCALIDAD;
SELECT * FROM KT_PARTES_INTERESADAS;
 
SELECT COUNT(PI.PARTE_INTERESADA_ID) as cantidadparte , P.DESCRIPCION FROM KT_PARTES_INTERESADAS PI
JOIN KT_PROCESOS P USING(PROCESO_ID) WHERE PI.PROCESO_ID = '1' GROUP BY P.DESCRIPCION;



SELECT * FROM KT_USUARIOSCROSS

SELECT * FROM KT_USERSAPP

/*Consulta para cambiar el estado a un usuario*/
update kt_usersapp set estado = 1 where rowid = 5;

DELETE  FROM KT_USERSAPP
