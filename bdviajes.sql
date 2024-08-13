CREATE DATABASE bdviajes; 

CREATE TABLE empresa(
    idEmpresa bigint AUTO_INCREMENT,
    eNombre varchar(150),
    eDireccion varchar(150),
    PRIMARY KEY (idEmpresa)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE responsable (
    numEmpleado bigint AUTO_INCREMENT,
    numLicencia bigint,
	nombre varchar(150), 
    apellido  varchar(150), 
    PRIMARY KEY (numEmpleado)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;;
	
CREATE TABLE viaje (
    idViaje bigint AUTO_INCREMENT, /*codigo de viaje*/
	destino varchar(150),
    cantMaxpasajeros int,
	idempresa bigint,
    numEmpResponsable bigint,
    importe float,
    PRIMARY KEY (idViaje),
    FOREIGN KEY (idEmpresa) REFERENCES empresa (idEmpresa),
	FOREIGN KEY (numEmpResponsable) REFERENCES responsable (numEmpleado)
    ON UPDATE CASCADE
    ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1;
	
CREATE TABLE pasajero (
    nombre varchar(150), 
    apellido varchar(150), 
    numDocumento varchar(15),
	telefono int, 
	idviaje bigint,
    PRIMARY KEY (numDocumento),
	FOREIGN KEY (idviaje) REFERENCES viaje (idViaje)	
    )ENGINE=InnoDB DEFAULT CHARSET=utf8; 
 
  
