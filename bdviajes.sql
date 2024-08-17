CREATE DATABASE bdviajes; 

CREATE TABLE empresa(
    idEmpresa bigint AUTO_INCREMENT,
    eNombre varchar(150),
    eDireccion varchar(150),
    PRIMARY KEY (idEmpresa)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE persona (
  numDocumento int(11) NOT NULL,
  apellido varchar(150) NOT NULL,
  nombre varchar(150) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE responsable (
    numEmpleado bigint AUTO_INCREMENT,
    numLicencia bigint,
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
    numDocumento varchar(15),
	telefono int, 
	idviaje bigint,
    PRIMARY KEY (numDocumento),
    FOREIGN KEY (numDocumento) REFERENCES persona (numDocumento),
	FOREIGN KEY (idviaje) REFERENCES viaje (idViaje)	
    )ENGINE=InnoDB DEFAULT CHARSET=utf8; 
 
  
