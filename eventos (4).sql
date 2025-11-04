-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-12-2024 a las 13:45:25
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `eventos`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizarusu` (IN `id` INT, IN `nom` VARCHAR(255), IN `psw` VARCHAR(255))   BEGIN
    -- Verificar si el usuario existe
    IF (SELECT COUNT(*) FROM usuario WHERE idusuario = id) = 0 THEN
        -- Si el usuario no existe, mostrar mensaje de error
        SELECT 'El usuario no existe' AS Resultado;
    ELSE
        -- Si el usuario existe, actualizar los datos
        UPDATE usuario 
        SET nomusu = nom, pasword = MD5(psw)
        WHERE idusuario = id;

        -- Mostrar mensaje de éxito
        SELECT 'El usuario se modificó correctamente' AS Resultado;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CRescuela` (`nomes` VARCHAR(45), `idfac` INT)   BEGIN
     IF(SELECT COUNT(*) FROM escuela WHERE nomescu=nomes and idfacultad=idfac)=0 THEN
     INSERT INTO escuela(nomescu,idfacultad) VALUES (nomes,idfac);
     SELECT 'La escuela se ingreso correctamente';
     ELSE
     SELECT 'La escuela ya existe';
     END IF;
     END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CRevento` (IN `evenom` TEXT, IN `fcini` DATE, IN `descrip` TEXT, IN `horin` TIME, IN `horc` TIME, IN `idtipev` INT)   BEGIN 
     IF(SELECT COUNT(*) FROM evento WHERE eventnom=evenom)=0 THEN
      INSERT INTO       evento(descripción,eventnom,fecini,horain,horcul,idestadoeve,idTipoeven)
      VALUES (descrip,evenom,fcini,horin,horc,2,idtipev );
      SELECT 'El evento se ingreso correctamente';
      ELSE
      SIGNAL SQLSTATE '45000'  
SET MESSAGE_TEXT = 'El evento ya existe';
      END IF;
      END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CRfacultad` (`nomfa` VARCHAR(100))   BEGIN
     IF(SELECT COUNT(*) FROM facultad WHERE nomfac=nomfa)=0 THEN
     INSERT INTO facultad(nomfac) VALUES (nomfa);
     SELECT 'La facultad se ingreso correctamente';
     ELSE
     SELECT 'La facultad ya existe';
     END IF;
     END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CRinfor` (IN `p_idevento` INT, IN `p_fecpres` DATE, IN `p_tipoinf` INT, IN `p_rta` TEXT)   BEGIN   
    IF p_fecpres <= CURDATE() THEN  
        IF NOT EXISTS (  
            SELECT 1   
            FROM informe   
            WHERE idevento = p_idevento  
        )   
        THEN   
            INSERT INTO informe(fecpres, idTipinfor, rta, idevento)   
            VALUES (p_fecpres, p_tipoinf, p_rta, p_idevento);  
        ELSE  
           SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT ='Registro duplicado en informe, no se realizó la inserción.';  
        END IF;  
    ELSE  
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT ='La fecha de presentación no puede ser mayor a hoy.';  
    END IF;  
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CRinscrip` (IN `dn` VARCHAR(10), IN `ape` VARCHAR(60), IN `dire` VARCHAR(60), IN `emal` VARCHAR(45), IN `idgener` INT, IN `nom` VARCHAR(50), IN `celu` VARCHAR(10), IN `idescu` INT, IN `ideven` INT)   BEGIN
    DECLARE pid INT;
    DECLARE idinsc INT;
    -- Buscar si la persona ya existe
    SELECT idpersona INTO pid  FROM personas WHERE dni = dn;
    -- Si la persona no existe, insertarla y obtener su ID
    IF pid IS NULL THEN INSERT INTO personas (apell, direc, dni, email, idgenero, nombre, tele)
        VALUES (ape, dire, dn, emal, idgener, nom, celu);
        SET pid = LAST_INSERT_ID();
        END IF;

    -- Verificar si la inscripcion ya existe
    IF (SELECT COUNT(*) FROM inscripcion WHERE idpersona = pid AND idescuela = idescu AND idevento = ideven) = 0 THEN
        INSERT INTO inscripcion (idescuela, idevento, idpersona)
        VALUES (idescu, ideven, pid);
        SELECT 'Se registró correctamente' AS mensaje;
        ELSE
        SELECT 'No se puede registrar dos veces' AS mensaje;
       END IF;
       
         SET idinsc = LAST_INSERT_ID();
        
      INSERT INTO asistencia(fech,idincrip,idtipasis,idestado)
      VALUES (NOW(),idinsc,2,1);
     SELECT 'La asistencia se registró correctamente';
   
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CRrecucontra` (IN `idu` INT, IN `ubig` TEXT, IN `fecem` DATE, IN `nomus` TEXT, IN `psw` TEXT, IN `idtipu` INT, IN `dni` VARCHAR(8))   BEGIN  
    IF (SELECT COUNT(*) FROM usuario WHERE idusuario <> idu and idTipUsua=idtipu and nomusu=nomus and md5(psw)=md5(pasword) and dniu=dni) = 0 THEN  
        UPDATE usuario   
        SET nomusu = nomus,   
            pasword = MD5(psw),   
            idTipUsua = idtipu,
ubigeo = md5(ubig), fechaemision=fecem, dniu=dni
        WHERE idusuario = idu;       
        SELECT 'El usuario se actualizó correctamente';    
    ELSE  
         SELECT 'El usuario ya existe';  
    END IF;  
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CRresol` (`num` VARCHAR(45), `fechapr` DATE, `idtipreso` INT, `idevent` INT, `rut` TEXT)   BEGIN  
    IF (SELECT COUNT(*) FROM resoluciaprob WHERE idevento = idevent) = 0 THEN  
        IF fechapr <= CURDATE() THEN  
            INSERT INTO resoluciaprob(nrores, fechapro, idTipresol, idevento, ruta, fecharegist)  
            VALUES (num, fechapr, idtipreso, idevent, rut, CURDATE());  
            SELECT 'Se registró correctamente';  
        ELSE  
             SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT =  'La fecha de aprobación de la resolución no puede ser mayor que la fecha actual';  
        END IF;  
    ELSE  
        SELECT 'El registro ya existe';  
    END IF;  
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CRtipeven` (`nomeve` VARCHAR(45))   BEGIN
     IF(SELECT COUNT(*) FROM tipoevento WHERE nomeven=nomeve)=0 THEN
     INSERT INTO tipoevento(nomeven) VALUES (nomeve);
     SELECT 'El tipo de evento se ingreso correctamente';
     ELSE
     SELECT 'El tipo de evento ya existe';
     END IF;
     END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CRTipoinforme` (IN `nomtinfor` VARCHAR(80))   BEGIN
    IF EXISTS (SELECT 1 FROM Tipoinforme WHERE nomtinform = nomtinfor) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El tipo de informe ya existe.';
    ELSE
        INSERT INTO Tipoinforme (nomtinform) VALUES (nomtinfor);
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CRTipoResolucion` (IN `p_nomtiprs` TEXT)   BEGIN  
    IF NOT EXISTS (SELECT 1 FROM tiporesolucion WHERE nomtiprs = p_nomtiprs) THEN  
        INSERT INTO tiporesolucion (nomtiprs) VALUES (p_nomtiprs);  
        SELECT 'Tipo de resolución creado exitosamente.' AS mensaje;  
    ELSE  
        SELECT 'El tipo de resolución ya existe.' AS mensaje;  
    END IF;  
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CRTipoUsuario` (IN `p_tipousu` VARCHAR(60))   BEGIN   
    IF NOT EXISTS (SELECT 1 FROM tipousuario WHERE tipousu = p_tipousu) THEN  
        INSERT INTO tipousuario (tipousu) VALUES (p_tipousu);  
        SELECT 'Tipo de usuario creado exitosamente.' AS mensaje;  
    ELSE  
        SELECT 'El tipo de usuario ya existe.' AS mensaje;  
    END IF;  
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CRtipusuario` (IN `nomtip` VARCHAR(50))   BEGIN
    DECLARE user_count INT;  -- Declaramos una variable para almacenar el resultado de COUNT
    
    -- Obtenemos el número de registros que coinciden con el tipo de usuario
    SELECT COUNT(*) INTO user_count FROM tipousuario WHERE tipousu = nomtip;
    
    -- Verificamos si no existe (user_count = 0)
    IF user_count = 0 THEN
        INSERT INTO tipousuario (tipousu) VALUES (nomtip);
        SELECT 'El tipo de usuario se ingresó correctamente';
    ELSE
        SELECT 'El tipo de usuario ya existe';
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CRusuario` (IN `nomus` VARCHAR(45), IN `paswor` VARCHAR(45), IN `idTipUsu` INT, IN `fecemi` DATE, IN `ubig` TEXT, IN `dni` VARCHAR(8))   BEGIN
     IF(SELECT COUNT(*) FROM usuario WHERE nomusu=nomus and idTipUsu=idTipUsua and paswor=pasword)>0         THEN
      SELECT 'El usuario ya existe';
     ELSE
     INSERT INTO usuario(nomusu,pasword,idTipUsua,fechaemision, ubigeo, dniu) VALUES (nomus, md5(paswor),idTipUsu,fecemi,md5(ubig),dni);
     SELECT 'El usuario se ingreso correctamente';
     END IF;
     END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CRusuperso` (`dn` VARCHAR(14), `ape` VARCHAR(60), `dire` VARCHAR(60), `emal` VARCHAR(45), `idgener` INT, `nom` VARCHAR(60), `celu` VARCHAR(15), `nomus` VARCHAR(45), `paswor` VARCHAR(45), `idTipUsu` INT)   BEGIN
     DECLARE pid INT;
     DECLARE idu INT;
    -- Buscar si la persona ya existe
    SELECT idpersona INTO pid  FROM personas WHERE dni = dn;
    -- Si la persona no existe, insertarla y obtener su ID
    IF pid IS NULL THEN INSERT INTO personas (apell, direc, dni, email, idgenero, nombre, tele)
        VALUES (ape, dire, dn, emal, idgener, nom, celu);
        SET pid = LAST_INSERT_ID();
        END IF;
        
     SELECT idusuario INTO idu  FROM usuario WHERE nomusu=nomus and idTipUsu=idTipUsua and paswor=pasword;
     
     IF idu IS NULL THEN INSERT INTO usuario(nomusu,pasword,idTipUsua) VALUES (nomus,         
       md5(paswor),idTipUsu);
      SET idu = LAST_INSERT_ID();
     SELECT 'El usuario se ingreso correctamente';
     END IF;
     
     
     IF(SELECT COUNT(*) FROM datosperusu WHERE idusuario=idu and idpersona=pid)>0         THEN
      SELECT 'La persona ya tiene un usuario';
     ELSE
     INSERT INTO datosperusu(idpersona,idusuario) VALUES (pid,idu);
     SELECT 'El usuario se ingreso correctamente';
     END IF;
     END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EditarUsuario` (IN `pidUsuario` INT, IN `pnomUs` VARCHAR(45), IN `ppaswor` VARCHAR(45), IN `pidTipUsu` INT, IN `dni` VARCHAR(8))   BEGIN  
    IF (SELECT COUNT(*) FROM usuario WHERE idusuario <> pidUsuario and pidTipUsu=idTipUsua and nomusu=pnomUs and ppaswor=md5(pasword)) = 0 THEN  
        UPDATE usuario   
        SET nomusu = pnomUs,   
            pasword = MD5(ppaswor),   
            idTipUsua = pidTipUsu, dniu=dni
        WHERE idusuario = pidUsuario;       
        SELECT 'El usuario se actualizó correctamente';    
    ELSE  
         SELECT 'El usuario ya existe';  
    END IF;  
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ELIescue` (`id` INT)   BEGIN
      IF (SELECT COUNT(*) FROM escuela WHERE idescuela=id)>0 THEN
      DELETE FROM escuela where idescuela=id;
      SELECT 'La escuela se eliminó correctamente';
     ELSE
     SELECT 'La escuela no se puede eliminar';
     END IF; 
     END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ELIfacu` (`id` INT)   BEGIN
      IF (SELECT COUNT(*) FROM facultad WHERE idfacultad=id)>0 THEN
      DELETE FROM facultad where idfacultad=id;
      SELECT 'La facultad se eliminó correctamente';
     ELSE
     SELECT 'La facultad no se puede eliminar';
     END IF; 
     END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ELIinforme` (IN `p_idinforme` INT)   BEGIN  
  DELETE FROM informe WHERE idinforme = p_idinforme;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ELIinscrip` (`id` INT)   BEGIN
  IF (SELECT COUNT(*) FROM inscripcion WHERE idincrip=id)>0 THEN
  DELETE FROM inscripcion where idincrip=id;
  SELECT 'Se liminó correctamente';
  ELSE
  SELECT 'No se puede eliminar';
  END IF; 
  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarUsuario` (IN `pidUsuario` INT)   BEGIN  
    IF (SELECT COUNT(*) FROM usuario WHERE idusuario = pidUsuario) = 0 THEN  
        SELECT 'El usuario no existe';  
    ELSE  
IF (SELECT COUNT(*) FROM usuario_permisos WHERE usuario_idusuario = pidUsuario) = 0 THEN 

        DELETE FROM usuario WHERE idusuario = pidUsuario;  
        SELECT 'El usuario se eliminó correctamente';
else
DELETE FROM usuario_permisos WHERE usuario_idusuario = pidUsuario;
  DELETE FROM usuario WHERE idusuario = pidUsuario;  
        SELECT 'El usuario se eliminó correctamente';
 END IF;
    END IF;  
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarUsudata` (IN `iddatos` INT)   BEGIN  
       DECLARE idus INT;
       SELECT idusuario INTO idus FROM datosperusu WHERE idatosPer = iddatos;
        DELETE FROM datosperusu WHERE idatosPer = iddatos; 
        SELECT 'El usuario se eliminó correctamente';  
        
        DELETE FROM usuario WHERE idusuario = idus;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminar_informe` (IN `p_idinforme` INT)   BEGIN
   
    IF EXISTS (SELECT 1 FROM informe WHERE idinforme = p_idinforme) THEN
        DELETE FROM informe WHERE idinforme = p_idinforme;

        SELECT 'Registro eliminado con éxito.';
    ELSE
        SELECT 'No existe registro en informe con el id proporcionado.';
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Eliresolucion` (`id` INT)   BEGIN  
        DELETE FROM resoluciaprob WHERE idreslaprb = id;  
        SELECT 'Se eliminó correctamente';  
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ELItipeven` (`id` INT)   BEGIN
  IF (SELECT COUNT(*) FROM tipoevento WHERE idTipoeven=id)>0 THEN
  DELETE FROM tipoevento where idTipoeven=id;
  SELECT 'El tipo de evento se eliminó correctamente';
  ELSE
  SELECT 'El tipo de evento no se puede eliminar';
  END IF; 
  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ELITipoinforme` (IN `idTipinfo` INT)   BEGIN
    DELETE FROM Tipoinforme WHERE idTipinfor = idTipinfo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ELITipousuario` (IN `p_idTipUsua` INT)   BEGIN  
    DELETE FROM tipousuario WHERE idTipUsua = p_idTipUsua;  
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ELIvento` (`id` INT)   BEGIN
  IF (SELECT COUNT(*) FROM evento WHERE idevento=id)>0 THEN
  DELETE FROM evento where idevento=id;
  SELECT 'El evento se eliminó correctamente';
  ELSE
  SELECT 'El evento no se puede eliminar';
  END IF; 
  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ELTipoResolucion` (IN `p_idTipresol` INT)   BEGIN  
    DECLARE tipoExistente INT;    
    SELECT COUNT(*) INTO tipoExistente FROM tiporesolucion WHERE idTipresol = p_idTipresol;  
    IF tipoExistente > 0 THEN  
        DELETE FROM tiporesolucion WHERE idTipresol = p_idTipresol;  
        SELECT 'Tipo de resolución eliminado exitosamente.' AS mensaje;  
    ELSE  
        SELECT 'No se encontró el tipo de resolución con ese ID.' AS mensaje;  
    END IF;  
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Eltipusu` (IN `id` INT, IN `nomtip` VARCHAR(50))   BEGIN
      IF (SELECT COUNT(*) FROM tipousuario WHERE idTipUsua=id)>0 THEN
      DELETE FROM tipousuario where idTipUsua=id;
      SELECT 'El tipo se eliminó correctamente';
     ELSE
     SELECT 'El tipo no se puede eliminar';
     END IF;     
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GenerarNumero` (IN `p_idEvento` INT, IN `p_prefijo` VARCHAR(45), IN `p_desde` INT, IN `p_hasta` INT)   BEGIN
    DECLARE total_registros INT;  
    DECLARE contador INT;
    DECLARE num_certificado VARCHAR(45);
    DECLARE done INT DEFAULT FALSE;     
    DECLARE v_idCertif INT;              

    DECLARE cur CURSOR FOR           
        SELECT c.idCertif
        FROM certificado c
        INNER JOIN certificacion cp ON cp.idcertificacn = c.idcertificacn
        INNER JOIN asistencia a ON a.idasistnc = c.idasistnc
        INNER JOIN inscripcion i ON i.idincrip = a.idincrip
        INNER JOIN personas p ON p.idpersona = i.idpersona
        WHERE cp.idevento = p_idEvento
        ORDER BY CONCAT_WS(' ', p.apell, p.nombre) ASC;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    -- Contar los registros disponibles
    SELECT COUNT(*) INTO total_registros
    FROM certificado c
    INNER JOIN certificacion cu ON cu.idcertificacn = c.idcertificacn
    WHERE cu.idevento = p_idEvento;

    -- Validar si hay suficientes registros
    IF total_registros < (p_hasta - p_desde + 1) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Error: No hay suficientes registros para cubrir el rango especificado.';
    END IF;

    -- Inicializar el contador desde el valor inicial
    SET contador = p_desde;

    -- Abrir el cursor para recorrer los registros disponibles
    OPEN cur;

    label_loop: LOOP
        FETCH cur INTO v_idCertif;
        
        -- Si no hay más registros, salir del bucle
        IF done THEN
            LEAVE label_loop;
        END IF;
        
        -- Generar el número de certificado
        SET num_certificado = CONCAT(p_prefijo, LPAD(contador, 3, '0'));

        -- Actualizar el número en la tabla certificado
        UPDATE certificado
        SET nro = num_certificado
        WHERE idCertif = v_idCertif;

        -- Incrementar el contador
        SET contador = contador + 1;

        -- Si el contador excede el rango especificado, salir del bucle
        IF contador > p_hasta THEN
            LEAVE label_loop;
        END IF;
    END LOOP;

    -- Cerrar el cursor
    CLOSE cur;

    -- Mensaje de confirmación
    SELECT CONCAT('Se generaron números para ', total_registros, ' registros disponibles.') AS Resultado;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MDasisten` (`id` INT, `idtipoasis` INT)   BEGIN
    DECLARE ideven INT;
    DECLARE idcerti INT;

    -- Actualizar asistencia
    UPDATE asistencia 
    SET fech = NOW(), idtipasis = idtipoasis
    WHERE idasistnc = id;
    
    SELECT 'La asistencia se modificó correctamente';

    -- Obtener el id del evento
    SELECT e.idevento INTO ideven 
    FROM asistencia a
    INNER JOIN inscripcion ins ON ins.idincrip = a.idincrip
    INNER JOIN evento e ON e.idevento = ins.idevento
    WHERE a.idasistnc = id;

    -- Verificar si ya existe una certificación con el mismo idevento
    SELECT idcertificacn INTO idcerti 
    FROM certificacion 
    WHERE idevento = ideven 
    LIMIT 1;  -- Asegura que solo se devuelva un registro

    -- Si no existe una certificación con el idevento dado, insertar una nueva
    IF idcerti IS NULL THEN
        INSERT INTO certificacion(fechora, idevento, obser) 
        VALUES ('0000-00-00 00:00:00', ideven, 'Ninguna');
        
        -- Obtener el último ID insertado en certificacion
        SET idcerti = LAST_INSERT_ID();
    END IF;

    -- Condiciones para la tabla certificado
    IF idtipoasis = 1 THEN
        -- Insertar en la tabla certificado solo si idtipasis = 1
        INSERT INTO certificado (nro, idestcer, idasistnc, idcertificacn, fecentrega) 
        VALUES ('Sin número', 3, id, idcerti, '0000-00-00 00:00:00');
    
    ELSEIF idtipoasis = 2 THEN
        -- Eliminar de la tabla certificado si idtipasis = 2 y ya existe el registro
        IF EXISTS (
            SELECT 1 FROM certificado WHERE idasistnc = id
        ) THEN
            DELETE FROM certificado WHERE idasistnc = id;
        END IF;
    END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MDcertestado` (IN `idcer` INT, IN `idestac` INT)   BEGIN  
    IF idestac = 2 THEN
        UPDATE certificado  
        SET fecentrega = NOW(), idestcer = 3 
        WHERE idCertif = idcer AND idestcer = 2;
    ELSEIF idestac = 3 THEN
        UPDATE certificado  
        SET fecentrega = NOW(), idestcer = 2 
        WHERE idCertif = idcer AND idestcer = 3;
    END IF;
    
    SELECT 'Se actualizó correctamente';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MDcerti` (IN `idcer` INT, IN `num` VARCHAR(45), IN `idesta` INT, IN `ob` TEXT)   BEGIN  
    DECLARE idcen int;
    
    SELECT c.idcertificacn  into idcen from certificado c
    INNER join certificacion ce on ce.idcertificacn=c.idcertificacn
    WHERE c.idCertif=idcer;
    
UPDATE certificacion  SET ob = obser,   fechora = now()   
WHERE idcertificacn = idcen;  

UPDATE certificado  SET fecentrega = now(),   nro = num,  idesta = idestcer  
WHERE idCertif = idcer and idestcer=2;   SELECT 'Se actualizó correctamente';    
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MDcertificacion` (IN `ideven` INT, IN `obse` TEXT)   BEGIN  
  
    
UPDATE certificacion  SET fechora = now(),   obser = obse
WHERE idevento = ideven;   SELECT 'Se actualizó correctamente';    
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MDcertinum` (IN `idcer` INT, IN `num` VARCHAR(50))   BEGIN
    DECLARE idcen INT;
    DECLARE estado INT;

    SELECT idestcer INTO estado
    FROM certificado
    WHERE idCertif = idcer;

    IF estado != 3 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El certificado ya está entregado';
    ELSE
        IF EXISTS (
            SELECT 1
            FROM certificado
            WHERE nro = num
            AND idcertificacn = (SELECT idcertificacn FROM certificado WHERE idCertif = idcer)
        ) THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Ya existe el número de certificado';
        ELSE
            UPDATE certificado
            SET fecentrega = NOW(),
                nro = num
            WHERE idCertif = idcer AND idestcer = 3;

            SELECT 'Se actualizó correctamente';
        END IF;
    END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MDestadasiten` (`ideven` INT)   BEGIN
    UPDATE asistencia 
    SET idestado = 2 
    WHERE idincrip IN (
        SELECT ins.idincrip 
        FROM inscripcion ins 
        INNER JOIN evento eve ON eve.idevento = ins.idevento 
        WHERE eve.idevento = ideven
    );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MDestadeven` (IN `ideven` INT, IN `idesta` INT)   BEGIN  
    IF idesta = 1 THEN
        UPDATE estadoevento  
        SET idestcer = 2
        WHERE idestadoeve = ideven AND idesta = 1;
    ELSEIF idesta = 2 THEN
        UPDATE estadoevento 
        SET  idestcer = 1 
        WHERE idestadoeve = ideven AND idesta = 2;
    END IF;
    
    SELECT 'Se actualizó correctamente';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MDestadoeven` (`ideven` INT)   BEGIN
        UPDATE evento
        SET idestadoeve = 1
        WHERE ideven = idevento;   
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MDevento` (IN `id` INT, IN `evenom` VARCHAR(60), IN `fcini` DATE, IN `descrip` VARCHAR(60), IN `horin` TIME, IN `horc` TIME, IN `idtipev` INT)   BEGIN
  IF (SELECT COUNT(*) FROM evento WHERE eventnom=evenom and idevento<>id)=0 THEN
  UPDATE evento set eventnom=evenom, fecini=fcini, horain=horin, 
  horcul=horc, idTipoeven=idtipev,
  descripción=descrip
  WHERE idevento=id;   
  SELECT 'El evento se modifico correctamente';
  ELSE
 SIGNAL SQLSTATE '45000'  
SET MESSAGE_TEXT =  'El evento puede generar duplicidad';
  END IF;
  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MDincripcion` (`idinscr` INT, `dn` VARCHAR(10), `ape` VARCHAR(60), `dire` VARCHAR(60), `emal` VARCHAR(45), `idgener` INT, `nom` VARCHAR(50), `celu` VARCHAR(10), `idescu` INT, `ideven` INT)   BEGIN
    DECLARE pid INT;
    SELECT idpersona INTO pid
    FROM inscripcion
    WHERE idincrip=idinscr;
    
  IF (SELECT COUNT(*) FROM personas WHERE dni=dn and idpersona<>pid)=0 THEN
  UPDATE personas set dni=dn, apell=ape, direc=dire, 
  email=emal, idgenero=idgener, nombre=nom,tele=celu
  WHERE idpersona=pid;  
  END IF;
  
  IF (SELECT COUNT(*) FROM inscripcion WHERE idevento=ideven and idpersona=pid AND
   idescuela=idescu  and idincrip<>idinscr)=0 THEN
  UPDATE inscripcion set idescuela=idescu,idevento=ideven, idpersona=pid
  WHERE idincrip=idinscr;  
  
  SELECT 'Se modifico los datos correctamente';
  ELSE
  SELECT 'Los nuevos datos puede generar duplicidad';
  END IF;
  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MDinforme` (IN `p_idinforme` INT, IN `p_idevento` INT, IN `p_fecpres` DATE, IN `p_tipoinf` INT, IN `p_rta` TEXT)   BEGIN  
    IF p_fecpres > NOW() THEN  
        SIGNAL SQLSTATE '45000'  
        SET MESSAGE_TEXT = 'La fecha de presentación no puede ser mayor a hoy.';  
    ELSE  
        -- Verificar si no existe un informe con el mismo idevento  
        IF NOT EXISTS (SELECT 1 FROM informe WHERE idevento = p_idevento AND idinforme <> p_idinforme) THEN  
           
            UPDATE informe  
            SET fecpres = p_fecpres,  
                idTipinfor = p_tipoinf,  
                rta = p_rta,  
                idevento = p_idevento  
            WHERE idinforme = p_idinforme;  
        ELSE  
            SIGNAL SQLSTATE '45000'  
            SET MESSAGE_TEXT = 'El evento ya está registrado para otro informe.';  
        END IF;  
    END IF;  
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MDresolapro` (`id` INT, `fechapr` DATE, `ideven` INT, `idtipreso` INT, `num` VARCHAR(45), `ruc` TEXT)   BEGIN  
    DECLARE ruta_actual TEXT;  

    SELECT ruta INTO ruta_actual FROM resoluciaprob WHERE idreslaprb = id;  

    IF (SELECT COUNT(*) FROM resoluciaprob WHERE idevento = ideven AND idreslaprb <> id) = 0 THEN  
        IF fechapr <= CURDATE() THEN  
            UPDATE resoluciaprob   
            SET fechapro = fechapr,  
                idevento = ideven,  
                idTipresol = idtipreso,  
                nrores = num,  
                ruta = IF(ruc IS NULL OR ruc = '', ruta_actual, ruc)  
            WHERE idreslaprb = id;   
            
            SELECT 'Se modificó correctamente';  
        ELSE  
           SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT ='La fecha de registro no puede ser mayor que la fecha actual';  
        END IF;  
    ELSE  
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Puede generar duplicidad';  
    END IF;  
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MDTipoinforme` (IN `idTipinfo` INT, IN `nomtinfor` VARCHAR(80))   BEGIN
   IF EXISTS (SELECT 1 FROM Tipoinforme WHERE nomtinform = nomtinfor AND idTipinfor <> idTipinfo) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El tipo de informe ya existe.';
    ELSE
        UPDATE Tipoinforme
        SET nomtinform = nomtinfor
        WHERE idTipinfor = idTipinfo;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MDusuperso` (`idatosPer` INT, `dn` VARCHAR(14), `ape` VARCHAR(60), `dire` VARCHAR(60), `emal` VARCHAR(45), `idgener` INT, `nom` VARCHAR(60), `celu` VARCHAR(15), `nomus` VARCHAR(45), `paswor` VARCHAR(45), `idTipUsu` INT)   BEGIN
     DECLARE pid INT;
     DECLARE idu INT;
    -- Buscar si la persona ya existe
    select p.idusuario INTO idu from datosperusu  p WHERE p.idatosPer=idatosPer;
    SELECT u.idpersona  into pid FROM datosperusu  u where u.idatosPer=idatosPer;
      
     IF (SELECT COUNT(*) FROM personas WHERE dni=dn and idpersona<>pid)=0 THEN
     UPDATE personas set dni=dn, apell=ape, direc=dire, 
     email=emal, idgenero=idgener, nombre=nom,tele=celu
     WHERE idpersona=pid;  
    END IF;
  
    IF (SELECT COUNT(*) FROM usuario WHERE idusuario <> idu and idTipUsu=idTipUsua and 
        nomusu=nomus and paswor=md5(pasword)) = 0 THEN  UPDATE usuario   SET nomusu = nomus, 
        pasword = MD5(paswor),idTipUsua = idTipUsu 
        WHERE idusuario = idu;       
        SELECT 'El usuario se actualizó correctamente';    
    ELSE  
         SELECT 'El usuario ya existe';  
    END IF;  
    
     END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MODescuel` (`id` INT, `nomes` VARCHAR(45), `idfa` INT)   BEGIN
     IF (SELECT COUNT(*) FROM escuela WHERE nomescu=nomes and idfacultad=idfa and         idescuela<>id)=0 THEN
     UPDATE escuela set nomescu=nomes,idfacultad=idfa
     WHERE idescuela=id;   
     SELECT 'La escuela se modifico correctamente';
     ELSE
     SELECT 'La escuela puede generar duplicidad';
     END IF;
     END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MODfacultad` (`id` INT, `nomfa` VARCHAR(100))   BEGIN
     IF (SELECT COUNT(*) FROM facultad WHERE nomfac=nomfa and idfacultad<>id)=0 THEN
     UPDATE facultad set nomfac=nomfa
     WHERE idfacultad=id;   
     SELECT 'La facultad se modifico correctamente';
     ELSE
     SELECT 'La facultad puede generar duplicidad';
     END IF;
     END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ModificarUsuario` (IN `id` INT, IN `nom` VARCHAR(255), IN `psw` VARCHAR(255))   BEGIN  
    IF (SELECT COUNT(*) FROM usuario WHERE idusuario = id) = 0 THEN  
        SELECT 'El usuario no existe' AS mensaje;  
    ELSE  
        UPDATE usuario   
        SET nomusu = nom, pasword = MD5(psw)   
        WHERE idusuario = id;  
        SELECT 'El usuario se modificó correctamente' AS mensaje;  
    END IF;  
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MODtipeven` (`id` INT, `nomtie` VARCHAR(45))   BEGIN
  IF (SELECT COUNT(*) FROM tipoevento WHERE nomeven=nomtie and idTipoeven<>id)=0 THEN
  UPDATE tipoevento set nomeven=nomtie
  WHERE idTipoeven=id;   
  SELECT 'El tipo de evento se modifico correctamente';
  ELSE
  SELECT 'El tipo de evento puede generar duplicidad';
  END IF;
  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MODtipusuario` (IN `id` INT, IN `nomtip` VARCHAR(50))   BEGIN
    DECLARE user_count INT;  -- Declaramos una variable para almacenar el resultado de COUNT
    
    -- Obtenemos el número de registros que coinciden con el tipo de usuario
    SELECT COUNT(*) INTO user_count 
    FROM tipousuario 
    WHERE tipousu = nomtip 
    AND idTipUsua <> id;
    
    -- Verificamos si no existe duplicidad (user_count = 0)
    IF user_count = 0 THEN
        -- Actualizamos el registro
        UPDATE tipousuario 
        SET tipousu = nomtip
        WHERE idTipUsua = id;
        
        SELECT 'El tipo de usuario se modificó correctamente';
    ELSE
        SELECT 'El tipo de usuario genera duplicidad';
    END IF;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UPTipoResolucion` (IN `p_idTipresol` INT, IN `p_nomtiprs` TEXT)   BEGIN  
    IF NOT EXISTS (SELECT 1 FROM tiporesolucion WHERE nomtiprs = p_nomtiprs AND idTipresol != p_idTipresol) THEN  
        UPDATE tiporesolucion  
        SET nomtiprs = p_nomtiprs  
        WHERE idTipresol = p_idTipresol;  
        SELECT 'Tipo de resolución actualizado exitosamente.' AS mensaje;  
    ELSE  
        SELECT 'El tipo de resolución ya existe, no se puede actualizar.' AS mensaje;  
    END IF;  
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UPTipoUsuario` (IN `p_idTipUsua` INT, IN `p_tipousu` VARCHAR(60))   BEGIN  
    IF NOT EXISTS (SELECT 1 FROM tipousuario WHERE tipousu = p_tipousu AND idTipUsua != p_idTipUsua) THEN  
        UPDATE tipousuario  
        SET tipousu = p_tipousu  
        WHERE idTipUsua = p_idTipUsua;  
        
        SELECT 'Tipo de usuario actualizado exitosamente.' AS mensaje;  
    ELSE  
       SIGNAL SQLSTATE '45000'  
        SET MESSAGE_TEXT = 'El tipo de usuario ya existe, no se puede actualizar.';  
    END IF;  
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `idasistnc` int(11) NOT NULL,
  `fech` datetime DEFAULT NULL,
  `idtipasis` int(11) NOT NULL,
  `idincrip` int(11) NOT NULL,
  `idestado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistencia`
--

INSERT INTO `asistencia` (`idasistnc`, `fech`, `idtipasis`, `idincrip`, `idestado`) VALUES
(1, '2024-12-06 18:52:33', 1, 1, 2),
(2, '2024-10-01 09:00:00', 1, 2, 1),
(3, '2024-10-01 09:00:00', 1, 3, 1),
(4, '2024-10-01 09:00:00', 1, 4, 2),
(5, '2024-10-01 09:00:00', 1, 5, 1),
(6, '2024-10-01 09:00:00', 2, 6, 2),
(7, '2024-10-01 09:00:00', 1, 7, 1),
(8, '2024-11-16 21:47:04', 1, 8, 2),
(9, '2024-10-01 09:00:00', 1, 9, 1),
(10, '2024-10-01 09:00:00', 1, 10, 1),
(11, '2024-10-30 14:23:23', 2, 16, 1),
(12, '2024-10-30 14:32:55', 2, 14, 1),
(13, '2024-10-30 14:34:53', 2, 17, 1),
(14, '2024-10-31 10:47:18', 2, 18, 1),
(15, '2024-10-31 11:18:54', 1, 19, 2),
(16, '2024-10-31 11:18:54', 1, 20, 2),
(17, '2024-11-14 12:03:49', 1, 21, 1),
(18, '2024-11-16 21:47:04', 1, 22, 1),
(19, '2024-11-16 21:47:04', 1, 23, 1),
(20, '2024-11-16 21:47:04', 1, 24, 1),
(21, '2024-11-16 21:47:04', 1, 25, 1),
(22, '2024-11-16 21:47:04', 1, 26, 1),
(23, '2024-11-16 21:54:21', 1, 27, 1),
(24, '2024-11-16 15:48:08', 2, 28, 1),
(25, '2024-11-16 15:48:43', 2, 29, 1),
(26, '2024-11-16 15:49:14', 2, 30, 1),
(27, '2024-11-16 15:49:43', 2, 31, 1),
(28, '2024-11-16 15:51:13', 2, 32, 1),
(29, '2024-11-16 21:45:02', 2, 33, 1),
(30, '2024-12-06 19:54:12', 1, 34, 1),
(31, '2024-12-06 19:54:12', 1, 35, 1),
(32, '2024-12-07 11:04:47', 2, 36, 1),
(33, '2024-12-07 17:21:07', 2, 37, 1),
(34, '2024-12-07 17:21:42', 2, 38, 1),
(35, '2024-12-07 11:22:35', 2, 39, 1);

--
-- Disparadores `asistencia`
--
DELIMITER $$
CREATE TRIGGER `asistencia_after_update` AFTER UPDATE ON `asistencia` FOR EACH ROW BEGIN
  DECLARE nombre_usuario VARCHAR(50);
  SET nombre_usuario = @usuario_logueado;
  INSERT INTO asistencia_audit (operation, idasistnc, fech, idtipasis, idincrip, idestado, modified_at, nomusu, usuario)
  VALUES ('UPDATE', NEW.idasistnc, NEW.fech, NEW.idtipasis, NEW.idincrip, NEW.idestado, NOW(), nombre_usuario, USER());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia_audit`
--

CREATE TABLE `asistencia_audit` (
  `audit_id` int(11) NOT NULL,
  `operation` enum('INSERT','UPDATE','DELETE') NOT NULL,
  `idasistnc` int(11) NOT NULL,
  `fech` datetime DEFAULT NULL,
  `idtipasis` int(11) DEFAULT NULL,
  `idincrip` int(11) DEFAULT NULL,
  `idestado` int(11) DEFAULT NULL,
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `nomusu` varchar(50) DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistencia_audit`
--

INSERT INTO `asistencia_audit` (`audit_id`, `operation`, `idasistnc`, `fech`, `idtipasis`, `idincrip`, `idestado`, `modified_at`, `nomusu`, `usuario`) VALUES
(1, 'UPDATE', 1, '2024-10-01 09:00:00', 1, 1, 2, '2024-11-16 20:22:18', NULL, 'root@localhost'),
(2, 'UPDATE', 1, '2024-11-16 15:25:23', 2, 1, 2, '2024-11-16 20:25:23', 'yabe', 'root@localhost'),
(3, 'UPDATE', 8, '2024-11-16 16:37:19', 1, 8, 2, '2024-11-16 21:37:19', 'yabe', 'root@localhost'),
(4, 'UPDATE', 18, '2024-11-16 16:37:19', 1, 22, 1, '2024-11-16 21:37:19', 'yabe', 'root@localhost'),
(5, 'UPDATE', 8, '2024-11-16 21:46:46', 2, 8, 2, '2024-11-17 02:46:46', 'yabe', 'root@localhost'),
(6, 'UPDATE', 18, '2024-11-16 21:46:46', 2, 22, 1, '2024-11-17 02:46:46', 'yabe', 'root@localhost'),
(7, 'UPDATE', 8, '2024-11-16 21:47:04', 1, 8, 2, '2024-11-17 02:47:04', 'yabe', 'root@localhost'),
(8, 'UPDATE', 18, '2024-11-16 21:47:04', 1, 22, 1, '2024-11-17 02:47:04', 'yabe', 'root@localhost'),
(9, 'UPDATE', 19, '2024-11-16 21:47:04', 1, 23, 1, '2024-11-17 02:47:04', 'yabe', 'root@localhost'),
(10, 'UPDATE', 20, '2024-11-16 21:47:04', 1, 24, 1, '2024-11-17 02:47:04', 'yabe', 'root@localhost'),
(11, 'UPDATE', 21, '2024-11-16 21:47:04', 1, 25, 1, '2024-11-17 02:47:04', 'yabe', 'root@localhost'),
(12, 'UPDATE', 22, '2024-11-16 21:47:04', 1, 26, 1, '2024-11-17 02:47:04', 'yabe', 'root@localhost'),
(13, 'UPDATE', 23, '2024-11-16 21:54:21', 1, 27, 1, '2024-11-17 02:54:21', 'yabe', 'root@localhost'),
(14, 'UPDATE', 10, '2024-10-01 09:00:00', 1, 10, 2, '2024-12-06 23:50:25', NULL, 'root@localhost'),
(15, 'UPDATE', 1, '2024-12-06 18:52:33', 1, 1, 2, '2024-12-06 23:52:33', 'Kath', 'root@localhost'),
(16, 'UPDATE', 10, '2024-10-01 09:00:00', 1, 10, 1, '2024-12-06 23:58:48', NULL, 'root@localhost'),
(17, 'UPDATE', 30, '2024-12-06 19:54:12', 1, 34, 1, '2024-12-07 00:54:12', 'yabe', 'root@localhost'),
(18, 'UPDATE', 31, '2024-12-06 19:54:12', 1, 35, 1, '2024-12-07 00:54:12', 'yabe', 'root@localhost');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificacion`
--

CREATE TABLE `certificacion` (
  `idcertificacn` int(11) NOT NULL,
  `fechora` datetime NOT NULL,
  `obser` text NOT NULL,
  `idevento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `certificacion`
--

INSERT INTO `certificacion` (`idcertificacn`, `fechora`, `obser`, `idevento`) VALUES
(1, '2024-11-16 16:49:39', 'no hubo nada de nada', 1),
(2, '2024-02-20 14:00:00', 'Retraso en la entrega por problemas logísticos.', 2),
(3, '2024-10-31 10:35:45', 'rerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', 3),
(4, '2024-11-14 11:53:25', 'Entrega de certificados en el eve', 4),
(5, '2024-05-22 11:30:00', 'Certificado no entregado debido a falta de documentación.', 5),
(6, '2024-11-16 21:59:01', 'Entrega en sede central el dia 2021', 6),
(7, '2024-10-31 10:37:57', 'yabethuwu7', 7),
(8, '2024-08-25 17:10:00', 'Certificados enviados por correo.', 8),
(9, '2024-09-14 12:00:00', 'Certificación entregada en la oficina principal.', 9),
(10, '2024-10-01 15:25:00', 'Certificación completa sin observaciones.', 10),
(11, '0000-00-00 00:00:00', 'Ninguna', 43),
(12, '2024-12-06 19:56:42', 'yo no soy', 47);

--
-- Disparadores `certificacion`
--
DELIMITER $$
CREATE TRIGGER `insertcertificacionre` BEFORE INSERT ON `certificacion` FOR EACH ROW BEGIN
    DECLARE v_count INT;

    -- Contar cuántos registros existen con el mismo idevento
    SELECT COUNT(*) INTO v_count 
    FROM certificacion 
    WHERE idevento = NEW.idevento;

    -- Si ya existe un registro con el mismo idevento, lanzar error
    IF v_count > 0 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Error: Ya existe una certificación para este evento.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updatecertificacion` BEFORE UPDATE ON `certificacion` FOR EACH ROW BEGIN
    DECLARE v_count INT;

    SELECT COUNT(*) INTO v_count 
    FROM certificacion 
    WHERE idevento = NEW.idevento 
      AND idcertificacn <> NEW.idcertificacn;

    IF v_count > 0 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Ya existe una certificación para este evento.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificado`
--

CREATE TABLE `certificado` (
  `idCertif` int(11) NOT NULL,
  `nro` varchar(45) NOT NULL,
  `idestcer` int(11) NOT NULL,
  `idasistnc` int(11) DEFAULT NULL,
  `fecentrega` datetime DEFAULT NULL,
  `idcertificacn` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `certificado`
--

INSERT INTO `certificado` (`idCertif`, `nro`, `idestcer`, `idasistnc`, `fecentrega`, `idcertificacn`) VALUES
(2, '8888', 3, 2, '2024-12-06 18:21:19', 1),
(3, '965645', 2, 3, '2024-12-06 16:03:27', 1),
(4, 'CERT-004', 2, 4, '2024-10-02 10:00:00', 2),
(5, 'CERT-005', 2, 5, '2024-10-02 10:00:00', 2),
(6, 'car001', 2, 6, '2024-11-15 05:51:06', 1),
(7, 'car002', 3, 7, '2024-12-06 18:55:05', 1),
(9, 'CERT-009', 2, 9, '2024-10-02 10:00:00', 2),
(10, 'CERT-010', 3, 10, '2024-12-06 18:55:01', 1),
(11, 'Sin número', 2, 15, '2024-11-15 05:51:41', 4),
(12, 'Sin número', 3, 16, '0000-00-00 00:00:00', 4),
(13, 'yabe001', 3, 17, '0000-00-00 00:00:00', 11),
(16, 'int006', 2, 8, '2024-11-16 21:57:34', 6),
(17, 'int001', 3, 18, '0000-00-00 00:00:00', 6),
(18, 'int003', 3, 19, '0000-00-00 00:00:00', 6),
(19, 'int004', 3, 20, '0000-00-00 00:00:00', 6),
(20, '8888', 2, 21, '2024-11-16 21:58:19', 6),
(21, 'int002', 3, 22, '0000-00-00 00:00:00', 6),
(22, 'int005', 3, 23, '0000-00-00 00:00:00', 6),
(23, 'Sin número', 3, 1, '0000-00-00 00:00:00', 1),
(24, '89998777', 2, 30, '2024-12-06 19:55:35', 12),
(25, 'yabe002', 2, 31, '2024-12-06 19:56:30', 12);

--
-- Disparadores `certificado`
--
DELIMITER $$
CREATE TRIGGER `certificado_update_audit` AFTER UPDATE ON `certificado` FOR EACH ROW BEGIN
    INSERT INTO Certificado_auditoria (
        operacion, usuario, fecha_operacion, descripcion, idoriginal
    )
    VALUES (
        'UPDATE', USER(), NOW(),
        CONCAT_WS(' ', 'Actualizó el certificado con número:', OLD.nro, 
                  'a número:', NEW.nro, 
                  'con nueva fecha de entrega:', NEW.fecentrega),
        NEW.idCertif
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificado_auditoria`
--

CREATE TABLE `certificado_auditoria` (
  `id_audit` int(11) NOT NULL,
  `operacion` varchar(10) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `fecha_operacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `descripcion` text DEFAULT NULL,
  `nombreusuario` varchar(50) DEFAULT NULL,
  `idoriginal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `certificado_auditoria`
--

INSERT INTO `certificado_auditoria` (`id_audit`, `operacion`, `usuario`, `fecha_operacion`, `descripcion`, `nombreusuario`, `idoriginal`) VALUES
(13, 'UPDATE', 'root@localhost', '2024-11-16 16:20:52', 'Actualizó el certificado con número: CERT-001 a número: CERT-001 con nueva fecha de entrega: 2024-11-16 11:20:52', 'yabe', 1),
(14, 'UPDATE', 'root@localhost', '2024-11-16 16:21:08', 'Actualizó el certificado con número: CERT-002 a número: CERT-002 con nueva fecha de entrega: 2024-11-16 11:21:08', 'yabe', 2),
(15, 'UPDATE', 'root@localhost', '2024-11-16 16:21:18', 'Actualizó el certificado con número: CERT-003 a número: CERT-003 con nueva fecha de entrega: 2024-11-16 11:21:18', 'yabe', 3),
(16, 'UPDATE', 'root@localhost', '2024-11-16 21:48:35', 'Actualizó el certificado con número: CERT-002 a número: CERT-002 con nueva fecha de entrega: 2024-11-16 16:48:35', 'yabe', 2),
(17, 'UPDATE', 'root@localhost', '2024-11-16 21:49:13', 'Actualizó el certificado con número: CERT-003 a número: 8888 con nueva fecha de entrega: 2024-11-16 16:49:13', 'yabe', 3),
(18, 'UPDATE', 'root@localhost', '2024-11-16 21:49:29', 'Actualizó el certificado con número: 8888 a número: 8888 con nueva fecha de entrega: 2024-11-16 16:49:29', 'yabe', 3),
(19, 'UPDATE', 'root@localhost', '2024-11-17 02:56:26', 'Actualizó el certificado con número: Sin número a número: int001 con nueva fecha de entrega: 0000-00-00 00:00:00', NULL, 17),
(20, 'UPDATE', 'root@localhost', '2024-11-17 02:56:26', 'Actualizó el certificado con número: Sin número a número: int002 con nueva fecha de entrega: 0000-00-00 00:00:00', NULL, 21),
(21, 'UPDATE', 'root@localhost', '2024-11-17 02:56:26', 'Actualizó el certificado con número: Sin número a número: int003 con nueva fecha de entrega: 0000-00-00 00:00:00', NULL, 18),
(22, 'UPDATE', 'root@localhost', '2024-11-17 02:56:26', 'Actualizó el certificado con número: Sin número a número: int004 con nueva fecha de entrega: 0000-00-00 00:00:00', NULL, 19),
(23, 'UPDATE', 'root@localhost', '2024-11-17 02:56:26', 'Actualizó el certificado con número: Sin número a número: int005 con nueva fecha de entrega: 0000-00-00 00:00:00', NULL, 22),
(24, 'UPDATE', 'root@localhost', '2024-11-17 02:56:26', 'Actualizó el certificado con número: Sin número a número: int006 con nueva fecha de entrega: 0000-00-00 00:00:00', NULL, 16),
(25, 'UPDATE', 'root@localhost', '2024-11-17 02:56:59', 'Actualizó el certificado con número: Sin número a número: 999999 con nueva fecha de entrega: 2024-11-16 21:56:59', 'yabe', 20),
(26, 'UPDATE', 'root@localhost', '2024-11-17 02:57:09', 'Actualizó el certificado con número: 999999 a número: 999999 con nueva fecha de entrega: 2024-11-16 21:57:09', 'yabe', 20),
(27, 'UPDATE', 'root@localhost', '2024-11-17 02:57:34', 'Actualizó el certificado con número: int006 a número: int006 con nueva fecha de entrega: 2024-11-16 21:57:34', 'yabe', 16),
(28, 'UPDATE', 'root@localhost', '2024-11-17 02:57:41', 'Actualizó el certificado con número: 999999 a número: 999999 con nueva fecha de entrega: 2024-11-16 21:57:41', 'yabe', 20),
(29, 'UPDATE', 'root@localhost', '2024-11-17 02:58:12', 'Actualizó el certificado con número: 999999 a número: 999999 con nueva fecha de entrega: 2024-11-16 21:58:12', 'yabe', 20),
(30, 'UPDATE', 'root@localhost', '2024-11-17 02:58:19', 'Actualizó el certificado con número: 999999 a número: 8888 con nueva fecha de entrega: 2024-11-16 21:58:19', 'yabe', 20),
(31, 'UPDATE', 'root@localhost', '2024-12-05 20:35:30', 'Actualizó el certificado con número: CERT-002 a número: CERT-002 con nueva fecha de entrega: 2024-12-05 15:35:30', 'Kath', 2),
(32, 'UPDATE', 'root@localhost', '2024-12-05 20:35:44', 'Actualizó el certificado con número: CERT-002 a número: CERT-002 con nueva fecha de entrega: 2024-12-05 15:35:44', 'Kath', 2),
(33, 'UPDATE', 'root@localhost', '2024-12-06 20:45:40', 'Actualizó el certificado con número: CERT-006 a número: yabe002 con nueva fecha de entrega: 2024-11-15 05:51:06', NULL, 6),
(34, 'UPDATE', 'root@localhost', '2024-12-06 20:46:45', 'Actualizó el certificado con número: 8888 a número: 6500 con nueva fecha de entrega: 2024-12-06 15:46:45', 'Kath', 3),
(35, 'UPDATE', 'root@localhost', '2024-12-06 20:48:27', 'Actualizó el certificado con número: 6500 a número: 6500 con nueva fecha de entrega: 2024-12-06 15:48:27', 'Kath', 3),
(36, 'UPDATE', 'root@localhost', '2024-12-06 20:48:31', 'Actualizó el certificado con número: CERT-002 a número: CERT-002 con nueva fecha de entrega: 2024-12-06 15:48:31', 'Kath', 2),
(37, 'UPDATE', 'root@localhost', '2024-12-06 20:48:40', 'Actualizó el certificado con número: CERT-002 a número: 6500 con nueva fecha de entrega: 2024-12-06 15:48:40', 'Kath', 2),
(38, 'UPDATE', 'root@localhost', '2024-12-06 20:48:53', 'Actualizó el certificado con número: 6500 a número: 6500 con nueva fecha de entrega: 2024-12-06 15:48:53', 'Kath', 2),
(39, 'UPDATE', 'root@localhost', '2024-12-06 20:49:02', 'Actualizó el certificado con número: 6500 a número: 999999 con nueva fecha de entrega: 2024-12-06 15:49:02', 'Kath', 2),
(40, 'UPDATE', 'root@localhost', '2024-12-06 21:03:27', 'Actualizó el certificado con número: 6500 a número: 965645 con nueva fecha de entrega: 2024-12-06 16:03:27', 'Kath', 3),
(41, 'UPDATE', 'root@localhost', '2024-12-06 22:57:25', 'Actualizó el certificado con número: 999999 a número: 999999 con nueva fecha de entrega: 2024-12-06 17:57:25', 'Kath', 2),
(42, 'UPDATE', 'root@localhost', '2024-12-06 22:57:35', 'Actualizó el certificado con número: 999999 a número: 999999000 con nueva fecha de entrega: 2024-12-06 17:57:35', 'Kath', 2),
(43, 'UPDATE', 'root@localhost', '2024-12-06 22:59:08', 'Actualizó el certificado con número: 999999000 a número: 999999000 con nueva fecha de entrega: 2024-12-06 17:59:08', 'Kath', 2),
(44, 'UPDATE', 'root@localhost', '2024-12-06 22:59:17', 'Actualizó el certificado con número: 999999000 a número: 8888 con nueva fecha de entrega: 2024-12-06 17:59:17', 'Kath', 2),
(45, 'UPDATE', 'root@localhost', '2024-12-06 22:59:30', 'Actualizó el certificado con número: 8888 a número: 89998777 con nueva fecha de entrega: 2024-12-06 17:59:30', 'Kath', 2),
(46, 'UPDATE', 'root@localhost', '2024-12-06 23:00:17', 'Actualizó el certificado con número: 89998777 a número: 89998777U con nueva fecha de entrega: 2024-12-06 18:00:17', 'Kath', 2),
(47, 'UPDATE', 'root@localhost', '2024-12-06 23:12:48', 'Actualizó el certificado con número: 89998777U a número: 999999 con nueva fecha de entrega: 2024-12-06 18:12:48', 'Kath', 2),
(48, 'UPDATE', 'root@localhost', '2024-12-06 23:14:51', 'Actualizó el certificado con número: 999999 a número: 89998777 con nueva fecha de entrega: 2024-12-06 18:14:51', 'Kath', 2),
(49, 'UPDATE', 'root@localhost', '2024-12-06 23:20:59', 'Actualizó el certificado con número: 89998777 a número: 8888 con nueva fecha de entrega: 2024-12-06 18:20:59', 'Kath', 2),
(50, 'UPDATE', 'root@localhost', '2024-12-06 23:21:04', 'Actualizó el certificado con número: 8888 a número: 8888 con nueva fecha de entrega: 2024-12-06 18:21:04', 'Kath', 2),
(51, 'UPDATE', 'root@localhost', '2024-12-06 23:21:10', 'Actualizó el certificado con número: 8888 a número: 8888 con nueva fecha de entrega: 2024-12-06 18:21:10', 'Kath', 2),
(52, 'UPDATE', 'root@localhost', '2024-12-06 23:21:15', 'Actualizó el certificado con número: 8888 a número: 8888 con nueva fecha de entrega: 2024-12-06 18:21:15', 'Kath', 2),
(53, 'UPDATE', 'root@localhost', '2024-12-06 23:21:19', 'Actualizó el certificado con número: 8888 a número: 8888 con nueva fecha de entrega: 2024-12-06 18:21:19', 'Kath', 2),
(54, 'UPDATE', 'root@localhost', '2024-12-06 23:29:01', 'Actualizó el certificado con número: yabe002 a número: yab-001 con nueva fecha de entrega: 2024-11-15 05:51:06', NULL, 6),
(55, 'UPDATE', 'root@localhost', '2024-12-06 23:29:01', 'Actualizó el certificado con número: CERT-007 a número: yab-002 con nueva fecha de entrega:', NULL, 7),
(56, 'UPDATE', 'root@localhost', '2024-12-06 23:29:24', 'Actualizó el certificado con número: yab-001 a número: hol001 con nueva fecha de entrega: 2024-11-15 05:51:06', NULL, 6),
(57, 'UPDATE', 'root@localhost', '2024-12-06 23:29:24', 'Actualizó el certificado con número: yab-002 a número: hol002 con nueva fecha de entrega:', NULL, 7),
(58, 'UPDATE', 'root@localhost', '2024-12-06 23:29:42', 'Actualizó el certificado con número: hol001 a número: yabe001 con nueva fecha de entrega: 2024-11-15 05:51:06', NULL, 6),
(59, 'UPDATE', 'root@localhost', '2024-12-06 23:30:49', 'Actualizó el certificado con número: yabe001 a número: car001 con nueva fecha de entrega: 2024-11-15 05:51:06', NULL, 6),
(60, 'UPDATE', 'root@localhost', '2024-12-06 23:30:49', 'Actualizó el certificado con número: hol002 a número: car002 con nueva fecha de entrega:', NULL, 7),
(61, 'UPDATE', 'root@localhost', '2024-12-06 23:31:07', 'Actualizó el certificado con número: Sin número a número: car001 con nueva fecha de entrega: 0000-00-00 00:00:00', NULL, 13),
(62, 'UPDATE', 'root@localhost', '2024-12-06 23:31:25', 'Actualizó el certificado con número: car001 a número: int001 con nueva fecha de entrega: 0000-00-00 00:00:00', NULL, 13),
(63, 'UPDATE', 'root@localhost', '2024-12-06 23:37:08', 'Actualizó el certificado con número: int001 a número: yabe001 con nueva fecha de entrega: 0000-00-00 00:00:00', NULL, 13),
(64, 'UPDATE', 'root@localhost', '2024-12-06 23:39:25', 'Actualizó el certificado con número: car001 a número: car001 con nueva fecha de entrega: 2024-11-15 05:51:06', NULL, 6),
(65, 'UPDATE', 'root@localhost', '2024-12-06 23:39:25', 'Actualizó el certificado con número: car002 a número: car002 con nueva fecha de entrega:', NULL, 7),
(66, 'UPDATE', 'root@localhost', '2024-12-06 23:39:43', 'Actualizó el certificado con número: car001 a número: car001 con nueva fecha de entrega: 2024-11-15 05:51:06', NULL, 6),
(67, 'UPDATE', 'root@localhost', '2024-12-06 23:40:30', 'Actualizó el certificado con número: car001 a número: car001 con nueva fecha de entrega: 2024-11-15 05:51:06', NULL, 6),
(68, 'UPDATE', 'root@localhost', '2024-12-06 23:55:04', 'Actualizó el certificado con número: CERT-010 a número: CERT-010 con nueva fecha de entrega: 2024-12-06 18:55:01', NULL, 10),
(69, 'UPDATE', 'root@localhost', '2024-12-06 23:55:09', 'Actualizó el certificado con número: car002 a número: car002 con nueva fecha de entrega: 2024-12-06 18:55:05', NULL, 7),
(70, 'UPDATE', 'root@localhost', '2024-12-07 00:55:16', 'Actualizó el certificado con número: Sin número a número: yabe001 con nueva fecha de entrega: 0000-00-00 00:00:00', NULL, 24),
(71, 'UPDATE', 'root@localhost', '2024-12-07 00:55:16', 'Actualizó el certificado con número: Sin número a número: yabe002 con nueva fecha de entrega: 0000-00-00 00:00:00', NULL, 25),
(72, 'UPDATE', 'root@localhost', '2024-12-07 00:55:30', 'Actualizó el certificado con número: yabe001 a número: 89998777 con nueva fecha de entrega: 2024-12-06 19:55:30', 'yabe', 24),
(73, 'UPDATE', 'root@localhost', '2024-12-07 00:55:35', 'Actualizó el certificado con número: 89998777 a número: 89998777 con nueva fecha de entrega: 2024-12-06 19:55:35', 'yabe', 24),
(74, 'UPDATE', 'root@localhost', '2024-12-07 00:56:30', 'Actualizó el certificado con número: yabe002 a número: yabe002 con nueva fecha de entrega: 2024-12-06 19:56:30', 'yabe', 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datosperusu`
--

CREATE TABLE `datosperusu` (
  `idusuario` int(11) NOT NULL,
  `idpersona` int(11) NOT NULL,
  `idatosPer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `escuela`
--

CREATE TABLE `escuela` (
  `idescuela` int(11) NOT NULL,
  `nomescu` varchar(45) NOT NULL,
  `idfacultad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `escuela`
--

INSERT INTO `escuela` (`idescuela`, `nomescu`, `idfacultad`) VALUES
(1, 'Matemática', 1),
(2, 'Estadística e Informática', 1),
(3, 'Ingeniería de Sistemas e Informática', 1),
(4, 'Enfermería', 2),
(5, 'Obstetricia', 2),
(6, 'Ingeniería Agrícola', 3),
(7, 'Agronomía', 3),
(8, 'Ingeniería de Minas', 4),
(9, 'Ingeniería Civil', 5),
(10, 'Arquitectura', 5),
(11, 'Ingeniería de Industrias Alimentarías', 6),
(12, 'Ingeniería Industrial', 6),
(13, 'Ingeniería Ambiental', 7),
(14, 'Ingeniería Sanitaria', 7),
(15, 'Economía', 8),
(16, 'Contabilidad', 8),
(17, 'Administración', 9),
(18, 'Turismo', 9),
(19, 'Comunicación Lingüística y Literatura', 10),
(20, 'Lengua Extranjera: Inglés', 10),
(21, 'Primaria y Educación Bilingüe Intercultural', 10),
(22, 'Matemática e Informática', 10),
(23, 'Ciencias de la Comunicación', 10),
(24, 'Arqueología', 10),
(25, 'Derecho', 11),
(26, 'Medicina Humana (en creación)', 12);

--
-- Disparadores `escuela`
--
DELIMITER $$
CREATE TRIGGER `evita_escuela_duplicada_insert` BEFORE INSERT ON `escuela` FOR EACH ROW BEGIN
    DECLARE contar INT;
    SELECT COUNT(*) INTO contar
    FROM escuela
    WHERE nomescu = NEW.nomescu;

    IF contar > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Ya existe la escuela';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `evita_escuela_duplicada_update` BEFORE UPDATE ON `escuela` FOR EACH ROW BEGIN
    DECLARE contar INT;
    SELECT COUNT(*) INTO contar
    FROM escuela
    WHERE nomescu = NEW.nomescu
    AND idescuela != NEW.idescuela;

    IF contar > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Ya existe la escuela';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `prevent_delete_escuela` BEFORE DELETE ON `escuela` FOR EACH ROW BEGIN  
    DECLARE count_related INT;  

    -- Contar cuántas filas en la tabla inscripcion están relacionadas con la escuela a eliminar  
    SELECT COUNT(*) INTO count_related  
    FROM inscripcion  
    WHERE idescuela = OLD.idescuela;  

    -- Verificar si existen filas relacionadas  
    IF count_related > 0 THEN  
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No se puede eliminar la escuela porque existen inscripciones relacionadas.';  
    END IF;  
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadocerti`
--

CREATE TABLE `estadocerti` (
  `idestcer` int(11) NOT NULL,
  `nomestadc` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estadocerti`
--

INSERT INTO `estadocerti` (`idestcer`, `nomestadc`) VALUES
(2, 'Entregado'),
(3, 'Pendiente');

--
-- Disparadores `estadocerti`
--
DELIMITER $$
CREATE TRIGGER `I_estad_certi` BEFORE INSERT ON `estadocerti` FOR EACH ROW BEGIN
    DECLARE contar INT;
    SELECT COUNT(*) INTO contar
    FROM estadoCerti
    WHERE nomestadc = NEW.nomestadc;

    IF contar > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Ya existe el estado de certificado';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `U_estad_certi` BEFORE UPDATE ON `estadocerti` FOR EACH ROW BEGIN
    DECLARE contar INT;
    SELECT COUNT(*) INTO contar 
    FROM estadoCerti
    WHERE nomestadc = NEW.nomestadc
    AND idestcer != NEW.idestcer;

    IF contar> 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Ya existe el estado de certificado';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadoevento`
--

CREATE TABLE `estadoevento` (
  `idestadoeve` int(11) NOT NULL,
  `nomestado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estadoevento`
--

INSERT INTO `estadoevento` (`idestadoeve`, `nomestado`) VALUES
(1, 'culminado'),
(2, 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `idevento` int(11) NOT NULL,
  `eventnom` text DEFAULT NULL,
  `idTipoeven` int(11) NOT NULL,
  `idestadoeve` int(11) DEFAULT NULL,
  `descripción` text DEFAULT NULL,
  `horain` time DEFAULT NULL,
  `horcul` time DEFAULT NULL,
  `fecini` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `evento`
--

INSERT INTO `evento` (`idevento`, `eventnom`, `idTipoeven`, `idestadoeve`, `descripción`, `horain`, `horcul`, `fecini`) VALUES
(1, 'Conferencia sobre Saluddd', 1, 2, 'Conferencia sobre la importancia de la salud', '09:00:00', '20:00:00', '2024-12-01'),
(2, 'Taller de Programación', 2, 2, 'Taller práctico de Python para principiantes', '10:00:00', '12:00:00', '2024-11-02'),
(3, 'Seminario de Innovación', 1, 2, 'Seminario sobre innovación tecnológica', '14:00:00', '16:00:00', '2024-10-03'),
(4, 'Exposición de Arte', 3, 2, 'Exposición de artistas local', '09:00:00', '10:00:00', '2024-10-31'),
(5, 'Jornada de Capacitación', 4, 2, 'Capacitación en habilidades blandas', '08:00:00', '10:00:00', '2024-11-10'),
(6, 'Feria de Emprendedores', 5, 1, 'Feria para apoyar a emprendedores locales', '09:00:00', '23:00:00', '2024-11-15'),
(7, 'Charla sobre Medio Ambiente', 6, 2, 'Importancia de la conservación ambiental', '15:00:00', '17:00:00', '2024-10-14'),
(8, 'Reunión de Networking', 8, 2, 'Oportunidades de negocio y colaboración', '11:00:00', '13:00:00', '2024-11-20'),
(9, 'Cine Fórum', 8, 2, 'Proyección de película seguida de debate', '19:00:00', '22:00:00', '2024-11-11'),
(10, 'Taller de Fotografía', 9, 2, 'Taller práctico para mejorar habilidades fotográficas', '09:00:00', '12:00:00', '2024-11-30'),
(11, 'Conferencia de Marketing', 2, 2, 'Tendencias en marketing digital', '10:00:00', '12:00:00', '2024-11-29'),
(12, 'Charla de Salud Mental', 9, 2, 'Hablando sobre la salud mental y bienestar', '13:00:00', '18:00:00', '2024-10-30'),
(13, 'Cocina Internacional', 6, 2, 'Taller de cocina de diversas culturas', '10:00:00', '14:00:00', '2024-11-02'),
(14, 'Festival de Música', 5, 2, 'Festival de bandas locales', '18:00:00', '23:00:00', '2024-11-09'),
(15, 'Foro Educativo', 2, 2, 'Debate sobre el futuro de la educación', '09:00:00', '11:00:00', '2024-08-15'),
(16, 'Seminario de Liderazgo', 10, 2, 'Desarrollo de habilidades de liderazgo', '14:00:00', '17:00:00', '2024-11-05'),
(17, 'Taller de Yoga', 4, 2, 'Sesiones de yoga para principiantes', '07:00:00', '09:00:00', '2024-11-06'),
(18, 'Charla sobre Finanzas', 5, 2, 'Manejo responsable de las finanzas personales', '18:00:00', '20:00:00', '2024-11-10'),
(19, 'Exposición de Ciencias', 3, 2, 'Muestra de proyectos científicos de estudiantes', '09:00:00', '15:00:00', '2024-11-08'),
(20, 'Cierre de Proyectos', 7, 1, 'Presentación de proyectos finales del semestre', '15:00:00', '17:00:00', '2024-09-02'),
(21, 'Simposio de Biotecnología', 1, 2, 'Simposio sobre avances en biotecnología', '09:30:00', '12:30:00', '2024-12-05'),
(22, 'Hackathon de Innovación', 2, 2, 'Competencia de desarrollo de proyectos tecnológicos', '10:00:00', '18:00:00', '2024-11-15'),
(23, 'Congreso de Educación', 1, 2, 'Congreso sobre metodologías educativas modernas', '08:00:00', '17:00:00', '2024-12-10'),
(24, 'Feria del Libro', 3, 2, 'Feria anual de editoriales y autores locales', '10:00:00', '18:00:00', '2024-11-20'),
(25, 'Curso de Negociación', 4, 2, 'Curso intensivo sobre habilidades de negociación', '09:00:00', '12:00:00', '2024-12-02'),
(26, 'Foro de Emprendimiento', 5, 2, 'Foro para fomentar el emprendimiento juvenil', '14:00:00', '17:00:00', '2024-11-25'),
(27, 'Conferencia de Inteligencia Artificial', 6, 2, 'Charla sobre aplicaciones de IA en la vida cotidiana', '15:00:00', '17:00:00', '2024-12-08'),
(28, 'Encuentro de Egresados', 8, 2, 'Reunión anual de exalumnos para networking', '11:00:00', '14:00:00', '2024-11-18'),
(29, 'Festival de Cortometrajes', 8, 2, 'Proyección y premiación de cortometrajes locales', '18:00:00', '22:00:00', '2024-11-28'),
(30, 'Workshop de Diseño Gráfico', 9, 2, 'Taller sobre técnicas avanzadas de diseño gráfico', '09:00:00', '13:00:00', '2024-12-12'),
(31, 'Seminario de Ciberseguridad', 2, 2, 'Seminario sobre protección y privacidad en línea', '10:00:00', '12:30:00', '2024-12-03'),
(32, 'Conferencia de Bienestar', 9, 1, 'Sesión sobre salud mental y bienestar integral', '14:00:00', '16:00:00', '2023-12-14'),
(33, 'Festival Gastronómico', 7, 2, 'Degustación y exposición de platillos locales', '11:00:00', '20:00:00', '2024-11-30'),
(34, 'Concierto de Navidad', 3, 2, 'Concierto navideño de coros y bandas locales', '19:00:00', '21:00:00', '2024-12-23'),
(35, 'Mesa Redonda sobre Ciencia', 5, 2, 'Discusión sobre temas científicos actuales', '15:00:00', '17:00:00', '2024-12-06'),
(36, 'Curso de Oratoria', 4, 1, 'Desarrollo de habilidades de comunicación y oratoria', '10:00:00', '13:00:00', '2023-11-03'),
(37, 'Taller de Meditación', 4, 2, 'Sesiones de meditación para reducir el estrés', '08:00:00', '10:00:00', '2024-12-01'),
(38, 'Seminario de Finanzas Personales', 5, 2, 'Cómo manejar las finanzas de manera eficiente', '18:30:00', '20:30:00', '2023-11-02'),
(39, 'Exposición de Arte Contemporáneo', 3, 2, 'Exhibición de obras de arte contemporáneo', '10:00:00', '16:00:00', '2024-12-10'),
(40, 'Presentación de Proyectos Finales', 7, 1, 'Presentación de proyectos de fin de año', '16:00:00', '18:00:00', '2023-12-14'),
(41, 'Flora y Fauna de la Selva', 8, 2, 'Flora y Fauna de la Selvaholaaaa', '07:00:00', '09:00:00', '2024-11-06'),
(42, 'Administracion de Base de Datos En sistemas e informaticaaaaaaaaaaaaiuhffjhefjig idfuhjerfbgj jgjdf hhhhhhhhhhhhhh gf  sssssssssssssss', 15, 2, 'Administracion de Base de Datos En sistemas e informaticaaaaaaaaaaaaiuhffjhefjig idfuhjerfbgj jgjdf', '08:11:00', '11:11:00', '2025-01-02'),
(43, 'hola yabeth uwu', 2, 2, 'no se la verdad nada sip', '11:55:00', '13:55:00', '2024-11-14'),
(47, 'yabeth', 1, 1, 'hola hola si si', '11:31:00', '12:32:00', '2024-12-06');

--
-- Disparadores `evento`
--
DELIMITER $$
CREATE TRIGGER `auditoriaevento` AFTER INSERT ON `evento` FOR EACH ROW BEGIN
    INSERT INTO Evento_auditoria ( operacion, usuario, descripcioneven, ideventooriginal)
    VALUES ('INSERT', USER(), concat_ws(' ', 'Insertó un nuevo evento: ', '"',NEW.eventnom,'"', 'con fecha:',new.fecini, 'con hora desde:', new.horain,'hasta:', new.horcul), new.idevento);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `editauditeven` AFTER UPDATE ON `evento` FOR EACH ROW BEGIN
    DECLARE descripcion TEXT DEFAULT '';

    -- Verifica cada cambio y concatena el mensaje correspondiente
    IF NEW.eventnom <> OLD.eventnom THEN
        SET descripcion = CONCAT(descripcion, 'Nombre del evento cambiado de:"',old.eventnom,'" a: "', NEW.eventnom, '". ');
    END IF;

    IF NEW.fecini <> OLD.fecini THEN
        SET descripcion = CONCAT(descripcion, 'Fecha del evento cambiada de: ',OLD.fecini,' a: ', NEW.fecini, '. ');
    END IF;

    IF NEW.horain <> OLD.horain THEN
        SET descripcion = CONCAT(descripcion, 'Hora de inicio cambiada de: ',OLD.horain,' a: ', NEW.horain, '. ');
    END IF;

    IF NEW.horcul <> OLD.horcul THEN
        SET descripcion = CONCAT(descripcion, 'Hora de fin cambiada de: ',OLD.horcul,' a: ', NEW.horcul, '. ');
    END IF;

    IF NEW.descripción <> OLD.descripción THEN
        SET descripcion = CONCAT(descripcion, 'Descripción cambiada de: "',OLD.descripción,'" a: "', NEW.descripción, '". ');
    END IF;

    -- Cambia la descripción específicamente cuando el estado cambia a 2 (CULMINADO)
    IF NEW.idestadoeve <> OLD.idestadoeve THEN
        IF NEW.idestadoeve = 1 THEN
            SET descripcion = CONCAT(descripcion, 'Estado cambiado a: CULMINADO. ');
        ELSE
            SET descripcion = CONCAT(descripcion, 'Estado cambiado a: "', NEW.idestadoeve, '" PENDIENTE. ');
        END IF;
    END IF;

    -- Inserta en la tabla de auditoría solo si hubo algún cambio
    IF descripcion <> '' THEN
        INSERT INTO Evento_auditoria (operacion, usuario, descripcioneven, ideventooriginal)
        VALUES ('UPDATE', USER(), descripcion, NEW.idevento);
    END IF;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `eliauditeven` AFTER DELETE ON `evento` FOR EACH ROW BEGIN
        INSERT INTO Evento_auditoria (operacion, usuario, descripcioneven, ideventooriginal)
        VALUES ('DELETE', USER(), concat('Se eliminó el evento: ',old.eventnom),old.idevento);
   

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `eliminarfkeven` BEFORE DELETE ON `evento` FOR EACH ROW BEGIN

    IF (SELECT COUNT(*) FROM certificacion WHERE idevento = OLD.idevento) > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'No se puede eliminar el evento porque tiene certificaciones asociadas.';
    END IF;

    IF (SELECT COUNT(*) FROM inscripcion WHERE idevento = OLD.idevento) > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'No se puede eliminar el evento porque tiene inscripciones asociadas.';
    END IF;

    IF (SELECT COUNT(*) FROM resoluciaprob WHERE idevento = OLD.idevento) > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'No se puede eliminar el evento porque tiene resoluciones aprobadas asociadas.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `inserfeceven` BEFORE INSERT ON `evento` FOR EACH ROW BEGIN
    IF NEW.fecini < CURDATE() THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'No se puede ingresar una fecha menor al día actual';
    END IF;

    IF NEW.horcul< NEW.horain  THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La hora de inicio no puede ser mayor que la de culminación';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento_auditoria`
--

CREATE TABLE `evento_auditoria` (
  `id_audit` int(11) NOT NULL,
  `operacion` varchar(45) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `fecha_operacion` datetime NOT NULL DEFAULT current_timestamp(),
  `descripcioneven` text NOT NULL,
  `nombreusuario` varchar(100) DEFAULT NULL,
  `ideventooriginal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `evento_auditoria`
--

INSERT INTO `evento_auditoria` (`id_audit`, `operacion`, `usuario`, `fecha_operacion`, `descripcioneven`, `nombreusuario`, `ideventooriginal`) VALUES
(1, 'INSERT', 'root@localhost', '2024-10-29 20:31:34', 'Insertó un nuevo evento:  \" Taller de Investigacion de matematica \" con fecha: 2024-11-14 con hora desde: 08:00:00 hasta: 10:00:00', 'Jean', 64),
(2, 'INSERT', 'root@localhost', '2024-10-29 20:35:27', 'Insertó un nuevo evento:  \" Investigacion de operaciones en empresas \" con fecha: 2025-02-20 con hora desde: 07:00:00 hasta: 10:00:00', 'kath', 66),
(3, 'UPDATE', 'root@localhost', '2024-10-29 21:14:39', 'Nombre del evento cambiado a: \"Taller de Investigacion de Arquitectura\". ', 'jean', 40),
(4, 'UPDATE', 'root@localhost', '2024-10-29 21:17:03', 'Nombre del evento cambiado a: \"Programación Orientada a Objetoss\". Descripción cambiada a: \"realizado por el ingeniero Miguel Silva Zapata\". ', 'kath', 42),
(5, 'UPDATE', 'root@localhost', '2024-10-29 21:17:58', 'Nombre del evento cambiado a: \"aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\". ', 'kath', 46),
(6, 'UPDATE', 'root@localhost', '2024-10-29 21:19:20', 'Nombre del evento cambiado a: \"eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee\". ', 'kath', 46),
(8, 'DELETE', 'root@localhost', '2024-10-29 21:35:32', 'Se eliminó el evento: Arquitecturas del computadorerfgwergtr', 'kath', 56),
(9, 'INSERT', 'root@localhost', '2024-10-29 22:12:08', 'Insertó un nuevo evento:  \" Simposio de Biotecnología \" con fecha: 2024-12-05 con hora desde: 09:30:00 hasta: 12:30:00', NULL, 67),
(10, 'INSERT', 'root@localhost', '2024-10-29 22:12:08', 'Insertó un nuevo evento:  \" Hackathon de Innovación \" con fecha: 2024-11-15 con hora desde: 10:00:00 hasta: 18:00:00', NULL, 68),
(11, 'INSERT', 'root@localhost', '2024-10-29 22:12:08', 'Insertó un nuevo evento:  \" Congreso de Educación \" con fecha: 2024-12-10 con hora desde: 08:00:00 hasta: 17:00:00', NULL, 69),
(12, 'INSERT', 'root@localhost', '2024-10-29 22:12:08', 'Insertó un nuevo evento:  \" Feria del Libro \" con fecha: 2024-11-20 con hora desde: 10:00:00 hasta: 18:00:00', NULL, 70),
(13, 'INSERT', 'root@localhost', '2024-10-29 22:12:08', 'Insertó un nuevo evento:  \" Curso de Negociación \" con fecha: 2024-12-02 con hora desde: 09:00:00 hasta: 12:00:00', NULL, 71),
(14, 'INSERT', 'root@localhost', '2024-10-29 22:12:08', 'Insertó un nuevo evento:  \" Foro de Emprendimiento \" con fecha: 2024-11-25 con hora desde: 14:00:00 hasta: 17:00:00', NULL, 72),
(15, 'INSERT', 'root@localhost', '2024-10-29 22:12:08', 'Insertó un nuevo evento:  \" Conferencia de Inteligencia Artificial \" con fecha: 2024-12-08 con hora desde: 15:00:00 hasta: 17:00:00', NULL, 73),
(16, 'INSERT', 'root@localhost', '2024-10-29 22:12:08', 'Insertó un nuevo evento:  \" Encuentro de Egresados \" con fecha: 2024-11-18 con hora desde: 11:00:00 hasta: 14:00:00', NULL, 74),
(17, 'INSERT', 'root@localhost', '2024-10-29 22:12:08', 'Insertó un nuevo evento:  \" Festival de Cortometrajes \" con fecha: 2024-11-28 con hora desde: 18:00:00 hasta: 22:00:00', NULL, 75),
(18, 'INSERT', 'root@localhost', '2024-10-29 22:12:08', 'Insertó un nuevo evento:  \" Workshop de Diseño Gráfico \" con fecha: 2024-12-12 con hora desde: 09:00:00 hasta: 13:00:00', NULL, 76),
(19, 'INSERT', 'root@localhost', '2024-10-29 22:12:08', 'Insertó un nuevo evento:  \" Seminario de Ciberseguridad \" con fecha: 2024-12-03 con hora desde: 10:00:00 hasta: 12:30:00', NULL, 77),
(20, 'INSERT', 'root@localhost', '2024-10-29 22:12:08', 'Insertó un nuevo evento:  \" Conferencia de Bienestar \" con fecha: 2024-12-14 con hora desde: 14:00:00 hasta: 16:00:00', NULL, 78),
(21, 'INSERT', 'root@localhost', '2024-10-29 22:12:08', 'Insertó un nuevo evento:  \" Festival Gastronómico \" con fecha: 2024-11-30 con hora desde: 11:00:00 hasta: 20:00:00', NULL, 79),
(22, 'INSERT', 'root@localhost', '2024-10-29 22:12:08', 'Insertó un nuevo evento:  \" Concierto de Navidad \" con fecha: 2024-12-23 con hora desde: 19:00:00 hasta: 21:00:00', NULL, 80),
(23, 'INSERT', 'root@localhost', '2024-10-29 22:12:08', 'Insertó un nuevo evento:  \" Mesa Redonda sobre Ciencia \" con fecha: 2024-12-06 con hora desde: 15:00:00 hasta: 17:00:00', NULL, 81),
(24, 'INSERT', 'root@localhost', '2024-10-29 22:12:08', 'Insertó un nuevo evento:  \" Curso de Oratoria \" con fecha: 2024-11-29 con hora desde: 10:00:00 hasta: 13:00:00', NULL, 82),
(25, 'INSERT', 'root@localhost', '2024-10-29 22:12:08', 'Insertó un nuevo evento:  \" Taller de Meditación \" con fecha: 2024-12-01 con hora desde: 08:00:00 hasta: 10:00:00', NULL, 83),
(26, 'INSERT', 'root@localhost', '2024-10-29 22:12:08', 'Insertó un nuevo evento:  \" Seminario de Finanzas Personales \" con fecha: 2024-11-27 con hora desde: 18:30:00 hasta: 20:30:00', NULL, 84),
(27, 'INSERT', 'root@localhost', '2024-10-29 22:12:08', 'Insertó un nuevo evento:  \" Exposición de Arte Contemporáneo \" con fecha: 2024-12-10 con hora desde: 10:00:00 hasta: 16:00:00', NULL, 85),
(28, 'INSERT', 'root@localhost', '2024-10-29 22:12:08', 'Insertó un nuevo evento:  \" Presentación de Proyectos Finales \" con fecha: 2024-12-15 con hora desde: 16:00:00 hasta: 18:00:00', NULL, 86),
(29, 'INSERT', 'root@localhost', '2024-10-30 09:40:39', 'Insertó un nuevo evento:  \" Conferencia sobre Salud \" con fecha: 2024-11-10 con hora desde: 09:00:00 hasta: 11:00:00', NULL, 1),
(30, 'INSERT', 'root@localhost', '2024-10-30 09:40:39', 'Insertó un nuevo evento:  \" Taller de Programación \" con fecha: 2024-11-02 con hora desde: 10:00:00 hasta: 12:00:00', NULL, 2),
(31, 'INSERT', 'root@localhost', '2024-10-30 09:40:39', 'Insertó un nuevo evento:  \" Seminario de Innovación \" con fecha: 2024-11-23 con hora desde: 14:00:00 hasta: 16:00:00', NULL, 3),
(32, 'INSERT', 'root@localhost', '2024-10-30 09:40:39', 'Insertó un nuevo evento:  \" Exposición de Arte \" con fecha: 2024-11-24 con hora desde: 18:00:00 hasta: 20:00:00', 'yabe', 4),
(33, 'INSERT', 'root@localhost', '2024-10-30 09:40:39', 'Insertó un nuevo evento:  \" Jornada de Capacitación \" con fecha: 2024-11-10 con hora desde: 08:00:00 hasta: 10:00:00', NULL, 5),
(34, 'INSERT', 'root@localhost', '2024-10-30 09:40:39', 'Insertó un nuevo evento:  \" Feria de Emprendedores \" con fecha: 2024-11-26 con hora desde: 09:00:00 hasta: 17:00:00', NULL, 6),
(35, 'INSERT', 'root@localhost', '2024-10-30 09:40:39', 'Insertó un nuevo evento:  \" Charla sobre Medio Ambiente \" con fecha: 2024-11-27 con hora desde: 15:00:00 hasta: 17:00:00', NULL, 7),
(36, 'INSERT', 'root@localhost', '2024-10-30 09:40:39', 'Insertó un nuevo evento:  \" Reunión de Networking \" con fecha: 2024-11-20 con hora desde: 11:00:00 hasta: 13:00:00', NULL, 8),
(37, 'INSERT', 'root@localhost', '2024-10-30 09:40:39', 'Insertó un nuevo evento:  \" Cine Fórum \" con fecha: 2024-11-11 con hora desde: 19:00:00 hasta: 22:00:00', NULL, 9),
(38, 'INSERT', 'root@localhost', '2024-10-30 09:40:39', 'Insertó un nuevo evento:  \" Taller de Fotografía \" con fecha: 2024-11-30 con hora desde: 09:00:00 hasta: 12:00:00', NULL, 10),
(39, 'INSERT', 'root@localhost', '2024-10-30 09:40:39', 'Insertó un nuevo evento:  \" Conferencia de Marketing \" con fecha: 2024-11-29 con hora desde: 10:00:00 hasta: 12:00:00', NULL, 11),
(40, 'INSERT', 'root@localhost', '2024-10-30 09:40:39', 'Insertó un nuevo evento:  \" Charla de Salud Mental \" con fecha: 2024-11-18 con hora desde: 16:00:00 hasta: 18:00:00', NULL, 12),
(41, 'INSERT', 'root@localhost', '2024-10-30 09:40:39', 'Insertó un nuevo evento:  \" Cocina Internacional \" con fecha: 2024-11-02 con hora desde: 10:00:00 hasta: 14:00:00', NULL, 13),
(42, 'INSERT', 'root@localhost', '2024-10-30 09:40:39', 'Insertó un nuevo evento:  \" Festival de Música \" con fecha: 2024-11-09 con hora desde: 18:00:00 hasta: 23:00:00', NULL, 14),
(43, 'INSERT', 'root@localhost', '2024-10-30 09:40:39', 'Insertó un nuevo evento:  \" Foro Educativo \" con fecha: 2024-11-04 con hora desde: 09:00:00 hasta: 11:00:00', NULL, 15),
(44, 'INSERT', 'root@localhost', '2024-10-30 09:40:39', 'Insertó un nuevo evento:  \" Seminario de Liderazgo \" con fecha: 2024-11-05 con hora desde: 14:00:00 hasta: 17:00:00', NULL, 16),
(45, 'INSERT', 'root@localhost', '2024-10-30 09:40:39', 'Insertó un nuevo evento:  \" Taller de Yoga \" con fecha: 2024-11-06 con hora desde: 07:00:00 hasta: 09:00:00', NULL, 17),
(46, 'INSERT', 'root@localhost', '2024-10-30 09:40:39', 'Insertó un nuevo evento:  \" Charla sobre Finanzas \" con fecha: 2024-11-10 con hora desde: 18:00:00 hasta: 20:00:00', NULL, 18),
(47, 'INSERT', 'root@localhost', '2024-10-30 09:40:39', 'Insertó un nuevo evento:  \" Exposición de Ciencias \" con fecha: 2024-11-08 con hora desde: 09:00:00 hasta: 15:00:00', NULL, 19),
(48, 'INSERT', 'root@localhost', '2024-10-30 09:40:39', 'Insertó un nuevo evento:  \" Cierre de Proyectos \" con fecha: 2024-11-08 con hora desde: 15:00:00 hasta: 17:00:00', NULL, 20),
(49, 'INSERT', 'root@localhost', '2024-10-30 09:41:08', 'Insertó un nuevo evento:  \" Simposio de Biotecnología \" con fecha: 2024-12-05 con hora desde: 09:30:00 hasta: 12:30:00', NULL, 21),
(50, 'INSERT', 'root@localhost', '2024-10-30 09:41:08', 'Insertó un nuevo evento:  \" Hackathon de Innovación \" con fecha: 2024-11-15 con hora desde: 10:00:00 hasta: 18:00:00', NULL, 22),
(51, 'INSERT', 'root@localhost', '2024-10-30 09:41:08', 'Insertó un nuevo evento:  \" Congreso de Educación \" con fecha: 2024-12-10 con hora desde: 08:00:00 hasta: 17:00:00', NULL, 23),
(52, 'INSERT', 'root@localhost', '2024-10-30 09:41:08', 'Insertó un nuevo evento:  \" Feria del Libro \" con fecha: 2024-11-20 con hora desde: 10:00:00 hasta: 18:00:00', NULL, 24),
(53, 'INSERT', 'root@localhost', '2024-10-30 09:41:08', 'Insertó un nuevo evento:  \" Curso de Negociación \" con fecha: 2024-12-02 con hora desde: 09:00:00 hasta: 12:00:00', NULL, 25),
(54, 'INSERT', 'root@localhost', '2024-10-30 09:41:08', 'Insertó un nuevo evento:  \" Foro de Emprendimiento \" con fecha: 2024-11-25 con hora desde: 14:00:00 hasta: 17:00:00', NULL, 26),
(55, 'INSERT', 'root@localhost', '2024-10-30 09:41:08', 'Insertó un nuevo evento:  \" Conferencia de Inteligencia Artificial \" con fecha: 2024-12-08 con hora desde: 15:00:00 hasta: 17:00:00', NULL, 27),
(56, 'INSERT', 'root@localhost', '2024-10-30 09:41:08', 'Insertó un nuevo evento:  \" Encuentro de Egresados \" con fecha: 2024-11-18 con hora desde: 11:00:00 hasta: 14:00:00', NULL, 28),
(57, 'INSERT', 'root@localhost', '2024-10-30 09:41:08', 'Insertó un nuevo evento:  \" Festival de Cortometrajes \" con fecha: 2024-11-28 con hora desde: 18:00:00 hasta: 22:00:00', NULL, 29),
(58, 'INSERT', 'root@localhost', '2024-10-30 09:41:08', 'Insertó un nuevo evento:  \" Workshop de Diseño Gráfico \" con fecha: 2024-12-12 con hora desde: 09:00:00 hasta: 13:00:00', NULL, 30),
(59, 'INSERT', 'root@localhost', '2024-10-30 09:41:08', 'Insertó un nuevo evento:  \" Seminario de Ciberseguridad \" con fecha: 2024-12-03 con hora desde: 10:00:00 hasta: 12:30:00', NULL, 31),
(60, 'INSERT', 'root@localhost', '2024-10-30 09:41:08', 'Insertó un nuevo evento:  \" Conferencia de Bienestar \" con fecha: 2024-12-14 con hora desde: 14:00:00 hasta: 16:00:00', NULL, 32),
(61, 'INSERT', 'root@localhost', '2024-10-30 09:41:08', 'Insertó un nuevo evento:  \" Festival Gastronómico \" con fecha: 2024-11-30 con hora desde: 11:00:00 hasta: 20:00:00', NULL, 33),
(62, 'INSERT', 'root@localhost', '2024-10-30 09:41:08', 'Insertó un nuevo evento:  \" Concierto de Navidad \" con fecha: 2024-12-23 con hora desde: 19:00:00 hasta: 21:00:00', NULL, 34),
(63, 'INSERT', 'root@localhost', '2024-10-30 09:41:08', 'Insertó un nuevo evento:  \" Mesa Redonda sobre Ciencia \" con fecha: 2024-12-06 con hora desde: 15:00:00 hasta: 17:00:00', NULL, 35),
(64, 'INSERT', 'root@localhost', '2024-10-30 09:41:08', 'Insertó un nuevo evento:  \" Curso de Oratoria \" con fecha: 2024-11-29 con hora desde: 10:00:00 hasta: 13:00:00', NULL, 36),
(65, 'INSERT', 'root@localhost', '2024-10-30 09:41:08', 'Insertó un nuevo evento:  \" Taller de Meditación \" con fecha: 2024-12-01 con hora desde: 08:00:00 hasta: 10:00:00', NULL, 37),
(66, 'INSERT', 'root@localhost', '2024-10-30 09:41:08', 'Insertó un nuevo evento:  \" Seminario de Finanzas Personales \" con fecha: 2024-11-27 con hora desde: 18:30:00 hasta: 20:30:00', NULL, 38),
(67, 'INSERT', 'root@localhost', '2024-10-30 09:41:08', 'Insertó un nuevo evento:  \" Exposición de Arte Contemporáneo \" con fecha: 2024-12-10 con hora desde: 10:00:00 hasta: 16:00:00', NULL, 39),
(68, 'INSERT', 'root@localhost', '2024-10-30 09:41:08', 'Insertó un nuevo evento:  \" Presentación de Proyectos Finales \" con fecha: 2024-12-15 con hora desde: 16:00:00 hasta: 18:00:00', NULL, 40),
(69, 'UPDATE', 'root@localhost', '2024-10-30 09:52:13', 'Fecha del evento cambiada de: 2024-11-10 a: 2024-10-09. ', NULL, 1),
(70, 'UPDATE', 'root@localhost', '2024-10-30 09:52:32', 'Fecha del evento cambiada de: 2024-11-23 a: 2024-10-03. ', NULL, 3),
(71, 'UPDATE', 'root@localhost', '2024-10-30 09:53:12', 'Fecha del evento cambiada de: 2024-11-27 a: 2024-10-14. ', NULL, 7),
(72, 'UPDATE', 'root@localhost', '2024-10-30 10:22:11', 'Fecha del evento cambiada de: 2024-11-04 a: 2024-08-15. ', NULL, 15),
(73, 'UPDATE', 'root@localhost', '2024-10-30 10:22:18', 'Fecha del evento cambiada de: 2024-11-08 a: 2024-09-02. ', NULL, 20),
(74, 'UPDATE', 'root@localhost', '2024-10-30 10:22:25', 'Fecha del evento cambiada de: 2024-11-18 a: 2024-10-15. ', NULL, 12),
(75, 'UPDATE', 'root@localhost', '2024-10-30 10:23:10', 'Fecha del evento cambiada de: 2024-12-14 a: 2023-12-14. ', NULL, 32),
(76, 'UPDATE', 'root@localhost', '2024-10-30 10:23:22', 'Fecha del evento cambiada de: 2024-11-27 a: 2023-11-02. ', NULL, 38),
(77, 'UPDATE', 'root@localhost', '2024-10-30 10:23:33', 'Fecha del evento cambiada de: 2024-11-29 a: 2023-11-03. ', NULL, 36),
(78, 'UPDATE', 'root@localhost', '2024-10-30 10:24:01', 'Fecha del evento cambiada de: 2024-12-15 a: 2023-12-14. ', NULL, 40),
(79, 'UPDATE', 'root@localhost', '2024-10-30 11:19:39', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 2),
(80, 'UPDATE', 'root@localhost', '2024-10-30 11:19:49', 'Estado cambiado a: CULMINADO. ', NULL, 3),
(81, 'UPDATE', 'root@localhost', '2024-10-30 11:19:57', 'Estado cambiado a: \"2\" PENDIENTE. ', 'yabe', 4),
(82, 'UPDATE', 'root@localhost', '2024-10-30 11:20:03', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 5),
(83, 'UPDATE', 'root@localhost', '2024-10-30 11:20:07', 'Estado cambiado a: CULMINADO. ', NULL, 6),
(84, 'UPDATE', 'root@localhost', '2024-10-30 11:20:16', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 7),
(85, 'UPDATE', 'root@localhost', '2024-10-30 11:21:39', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 6),
(86, 'UPDATE', 'root@localhost', '2024-10-30 11:21:50', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 8),
(87, 'UPDATE', 'root@localhost', '2024-10-30 11:21:54', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 9),
(88, 'UPDATE', 'root@localhost', '2024-10-30 11:22:00', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 11),
(89, 'UPDATE', 'root@localhost', '2024-10-30 11:22:08', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 14),
(90, 'UPDATE', 'root@localhost', '2024-10-30 11:22:14', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 16),
(91, 'UPDATE', 'root@localhost', '2024-10-30 11:22:19', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 17),
(92, 'UPDATE', 'root@localhost', '2024-10-30 11:22:27', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 19),
(93, 'UPDATE', 'root@localhost', '2024-10-30 11:22:33', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 21),
(94, 'UPDATE', 'root@localhost', '2024-10-30 11:22:38', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 22),
(95, 'UPDATE', 'root@localhost', '2024-10-30 11:22:47', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 24),
(96, 'UPDATE', 'root@localhost', '2024-10-30 11:22:50', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 25),
(97, 'UPDATE', 'root@localhost', '2024-10-30 11:22:59', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 27),
(98, 'UPDATE', 'root@localhost', '2024-10-30 11:23:02', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 28),
(99, 'UPDATE', 'root@localhost', '2024-10-30 11:23:06', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 29),
(100, 'UPDATE', 'root@localhost', '2024-10-30 11:23:13', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 31),
(101, 'UPDATE', 'root@localhost', '2024-10-30 11:23:15', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 32),
(102, 'UPDATE', 'root@localhost', '2024-10-30 11:23:21', 'Estado cambiado a: CULMINADO. ', NULL, 32),
(103, 'UPDATE', 'root@localhost', '2024-10-30 11:23:31', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 34),
(104, 'UPDATE', 'root@localhost', '2024-10-30 11:23:35', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 35),
(105, 'UPDATE', 'root@localhost', '2024-10-30 11:23:41', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 37),
(106, 'UPDATE', 'root@localhost', '2024-10-30 11:23:46', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 39),
(107, 'UPDATE', 'root@localhost', '2024-10-30 11:36:24', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 1),
(108, 'UPDATE', 'root@localhost', '2024-10-30 11:55:02', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 3),
(109, 'INSERT', 'root@localhost', '2024-10-30 12:07:16', 'Insertó un nuevo evento:  \" Flora y Fauna de la Selva \" con fecha: 2024-11-06 con hora desde: 07:00:00 hasta: 09:00:00', 'kath', 41),
(110, 'UPDATE', 'root@localhost', '2024-10-30 12:07:31', 'Descripción cambiada de: \"Flora y Fauna de la Selva\" a: \"Flora y Fauna de la Selvaholaaaa\". ', 'kath', 41),
(111, 'UPDATE', 'root@localhost', '2024-10-30 12:33:00', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 12),
(112, 'UPDATE', 'root@localhost', '2024-10-30 12:38:42', 'Fecha del evento cambiada de: 2024-10-15 a: 2024-10-09. ', NULL, 12),
(113, 'UPDATE', 'root@localhost', '2024-10-30 12:42:53', 'Estado cambiado a: \"2\" PENDIENTE. ', NULL, 15),
(114, 'UPDATE', 'root@localhost', '2024-10-30 14:18:26', 'Fecha del evento cambiada de: 2024-10-09 a: 2024-10-30. ', NULL, 12),
(115, 'UPDATE', 'root@localhost', '2024-10-30 14:18:33', 'Fecha del evento cambiada de: 2024-10-30 a: 2024-10-31. ', NULL, 12),
(116, 'UPDATE', 'root@localhost', '2024-10-30 14:20:04', 'Fecha del evento cambiada de: 2024-10-31 a: 2024-10-30. ', NULL, 12),
(117, 'UPDATE', 'root@localhost', '2024-10-30 14:20:17', 'Hora de inicio cambiada de: 16:00:00 a: 14:00:00. ', NULL, 12),
(118, 'UPDATE', 'root@localhost', '2024-10-30 14:21:35', 'Hora de inicio cambiada de: 14:00:00 a: 13:00:00. ', NULL, 12),
(119, 'INSERT', 'root@localhost', '2024-10-31 11:11:59', 'Insertó un nuevo evento:  \" Administracion de Base de Datos En sistemas e informaticaaaaaaaaaaaaiuhffjhefjig idfuhjerfbgj jgjdf hhhhhhhhhhhhhh gf  sssssssssssssss \" con fecha: 2025-01-02 con hora desde: 08:11:00 hasta: 11:11:00', 'kath', 42),
(120, 'UPDATE', 'root@localhost', '2024-10-31 11:17:40', 'Fecha del evento cambiada de: 2024-11-24 a: 2024-10-31. Hora de inicio cambiada de: 18:00:00 a: 11:00:00. Hora de fin cambiada de: 20:00:00 a: 13:00:00. ', 'yabe', 4),
(121, 'UPDATE', 'root@localhost', '2024-10-31 11:22:40', 'Hora de inicio cambiada de: 11:00:00 a: 09:00:00. Hora de fin cambiada de: 13:00:00 a: 11:25:00. ', 'yabe', 4),
(122, 'UPDATE', 'root@localhost', '2024-10-31 11:34:08', 'Hora de fin cambiada de: 11:25:00 a: 10:00:00. ', 'yabe', 4),
(123, 'INSERT', 'root@localhost', '2024-11-14 11:55:31', 'Insertó un nuevo evento:  \" hola yabeth \" con fecha: 2024-11-16 con hora desde: 13:55:00 hasta: 15:55:00', 'yabe', 43),
(124, 'UPDATE', 'root@localhost', '2024-11-14 11:57:46', 'Descripción cambiada de: \"no se la verdad nada\" a: \"no se la verdad nada sip\". ', 'yabe', 43),
(125, 'UPDATE', 'root@localhost', '2024-11-14 12:03:05', 'Fecha del evento cambiada de: 2024-11-16 a: 2024-11-14. ', 'yabe', 43),
(126, 'UPDATE', 'root@localhost', '2024-11-14 12:03:21', 'Hora de inicio cambiada de: 13:55:00 a: 11:55:00. ', 'yabe', 43),
(127, 'UPDATE', 'root@localhost', '2024-11-14 12:03:28', 'Hora de fin cambiada de: 15:55:00 a: 13:55:00. ', 'yabe', 43),
(128, 'UPDATE', 'root@localhost', '2024-11-15 22:51:44', 'Descripción cambiada de: \"Exposición de artistas locales\" a: \"Exposición de artistas local\". ', 'yabe', 4),
(129, 'UPDATE', 'root@localhost', '2024-11-15 22:58:48', 'Nombre del evento cambiado de:\"hola yabeth\" a: \"hola yabeth uwu\". ', 'yabe', 43),
(130, 'UPDATE', 'root@localhost', '2024-11-15 23:03:14', 'Nombre del evento cambiado de:\"Charla de Salud Mental\" a: \"Charla de Salud Mental ...\". ', NULL, 12),
(131, 'UPDATE', 'root@localhost', '2024-11-15 23:06:15', 'Nombre del evento cambiado de:\"Charla de Salud Mental ...\" a: \"Charla de Salud Mental\". ', NULL, 12),
(132, 'UPDATE', 'root@localhost', '2024-11-15 23:08:37', 'Nombre del evento cambiado de:\"Charla de Salud Mental\" a: \"Charla de Salud Mental ...\". ', NULL, 12),
(133, 'UPDATE', 'root@localhost', '2024-11-15 23:17:32', 'Nombre del evento cambiado de:\"Charla de Salud Mental ...\" a: \"Charla de Salud Mental\". ', NULL, 12),
(134, 'UPDATE', 'root@localhost', '2024-11-15 23:18:42', 'Nombre del evento cambiado de:\"Charla de Salud Mental\" a: \"Charla de Salud Mental..\". ', NULL, 12),
(135, 'UPDATE', 'root@localhost', '2024-11-15 23:20:07', 'Nombre del evento cambiado de:\"Charla de Salud Mental..\" a: \"Charla de Salud Mental\". ', NULL, 12),
(136, 'UPDATE', 'root@localhost', '2024-11-15 23:27:35', 'Nombre del evento cambiado de:\"Conferencia sobre Salud\" a: \"Conferencia sobre Salu\". ', NULL, 1),
(137, 'UPDATE', 'root@localhost', '2024-11-15 23:29:20', 'Nombre del evento cambiado de:\"Conferencia sobre Salu\" a: \"Conferencia sobre Salu.\". ', 'yabe', 1),
(138, 'UPDATE', 'root@localhost', '2024-11-15 23:41:01', 'Nombre del evento cambiado de:\"Conferencia sobre Salu.\" a: \"Conferencia sobre Salu\". ', NULL, 1),
(139, 'UPDATE', 'root@localhost', '2024-11-16 09:55:53', 'Nombre del evento cambiado de:\"Conferencia sobre Salu\" a: \"Conferencia sobre Salud\". ', NULL, 1),
(140, 'UPDATE', 'root@localhost', '2024-11-16 09:57:20', 'Nombre del evento cambiado de:\"Conferencia sobre Salud\" a: \"Conferencia sobre Salu\". ', NULL, 1),
(141, 'UPDATE', 'root@localhost', '2024-11-16 09:59:44', 'Nombre del evento cambiado de:\"Conferencia sobre Salu\" a: \"Conferencia sobre Sald\". ', NULL, 1),
(142, 'UPDATE', 'root@localhost', '2024-11-16 10:01:58', 'Nombre del evento cambiado de:\"Conferencia sobre Sald\" a: \"Conferencia sobre Salud\". ', NULL, 1),
(143, 'UPDATE', 'root@localhost', '2024-11-16 10:06:11', 'Nombre del evento cambiado de:\"Conferencia sobre Salud\" a: \"Conferencia sobre Saludd\". ', NULL, 1),
(144, 'UPDATE', 'root@localhost', '2024-11-16 10:08:25', 'Nombre del evento cambiado de:\"Conferencia sobre Saludd\" a: \"Conferencia sobre Salud\". ', NULL, 1),
(145, 'UPDATE', 'root@localhost', '2024-11-16 10:14:18', 'Nombre del evento cambiado de:\"Conferencia sobre Salud\" a: \"Conferencia sobre Saluddd\". ', 'yabe', 1),
(146, 'INSERT', 'root@localhost', '2024-11-16 11:12:07', 'Insertó un nuevo evento:  \" yabe \" con fecha: 2024-11-19 con hora desde: 14:11:00 hasta: 15:12:00', 'yabe', 44),
(147, 'UPDATE', 'root@localhost', '2024-11-16 11:12:21', 'Nombre del evento cambiado de:\"yabe\" a: \"yabeb\". ', 'yabe', 44),
(148, 'DELETE', 'root@localhost', '2024-11-16 11:12:32', 'Se eliminó el evento: yabeb', 'yabe', 44),
(149, 'UPDATE', 'root@localhost', '2024-11-16 15:24:56', 'Fecha del evento cambiada de: 2024-10-09 a: 2024-11-16. ', NULL, 1),
(150, 'UPDATE', 'root@localhost', '2024-11-16 15:25:07', 'Hora de fin cambiada de: 11:00:00 a: 16:00:00. ', NULL, 1),
(151, 'UPDATE', 'root@localhost', '2024-11-16 16:03:54', 'Fecha del evento cambiada de: 2024-11-26 a: 2024-11-16. ', NULL, 6),
(152, 'INSERT', 'root@localhost', '2024-11-16 21:33:55', 'Insertó un nuevo evento:  \" Conferencia \" con fecha: 2024-11-22 con hora desde: 10:33:00 hasta: 11:33:00', 'yabe', 45),
(153, 'UPDATE', 'root@localhost', '2024-11-16 21:34:17', 'Nombre del evento cambiado de:\"Conferencia\" a: \"Conferencia de ciencias\". ', 'yabe', 45),
(154, 'DELETE', 'root@localhost', '2024-11-16 21:34:29', 'Se eliminó el evento: Conferencia de ciencias', 'yabe', 45),
(155, 'UPDATE', 'root@localhost', '2024-11-16 21:48:51', 'Hora de fin cambiada de: 17:00:00 a: 13:00:00. ', NULL, 6),
(156, 'UPDATE', 'root@localhost', '2024-11-16 21:52:08', 'Hora de fin cambiada de: 13:00:00 a: 22:00:00. ', 'yabe', 6),
(157, 'UPDATE', 'root@localhost', '2024-11-16 21:52:32', 'Hora de fin cambiada de: 22:00:00 a: 23:00:00. ', 'yabe', 6),
(158, 'INSERT', 'root@localhost', '2024-11-16 21:53:03', 'Insertó un nuevo evento:  \" hola \" con fecha: 2024-11-21 con hora desde: 21:52:00 hasta: 23:53:00', 'yabe', 46),
(159, 'UPDATE', 'root@localhost', '2024-11-16 21:55:32', 'Fecha del evento cambiada de: 2024-11-16 a: 2024-11-15. ', NULL, 6),
(160, 'UPDATE', 'root@localhost', '2024-11-16 21:59:35', 'Estado cambiado a: CULMINADO. ', NULL, 6),
(161, 'UPDATE', 'root@localhost', '2024-12-06 18:51:49', 'Fecha del evento cambiada de: 2024-11-16 a: 2024-12-06. ', NULL, 1),
(162, 'UPDATE', 'root@localhost', '2024-12-06 18:52:03', 'Hora de fin cambiada de: 16:00:00 a: 20:00:00. ', NULL, 1),
(163, 'UPDATE', 'root@localhost', '2024-12-06 18:53:24', 'Fecha del evento cambiada de: 2024-12-06 a: 2024-12-01. ', NULL, 1),
(164, 'INSERT', 'root@localhost', '2024-12-06 19:32:17', 'Insertó un nuevo evento:  \" yabeth \" con fecha: 2024-12-11 con hora desde: 11:31:00 hasta: 12:32:00', 'yabe', 47),
(165, 'UPDATE', 'root@localhost', '2024-12-06 19:32:41', 'Descripción cambiada de: \"hola hola\" a: \"hola hola si si\". ', 'yabe', 47),
(166, 'DELETE', 'root@localhost', '2024-12-06 19:32:53', 'Se eliminó el evento: hola', 'yabe', 46),
(167, 'UPDATE', 'root@localhost', '2024-12-06 19:53:48', 'Fecha del evento cambiada de: 2024-12-11 a: 2024-12-06. ', NULL, 47),
(168, 'UPDATE', 'root@localhost', '2024-12-06 19:53:58', 'Hora de fin cambiada de: 12:32:00 a: 21:32:00. ', NULL, 47),
(169, 'UPDATE', 'root@localhost', '2024-12-06 19:54:56', 'Hora de fin cambiada de: 21:32:00 a: 12:32:00. ', NULL, 47),
(170, 'UPDATE', 'root@localhost', '2024-12-06 19:56:55', 'Estado cambiado a: CULMINADO. ', NULL, 47),
(171, 'INSERT', 'root@localhost', '2024-12-07 11:27:07', 'Insertó un nuevo evento:  \" Conferencia sobre Saluddd \" con fecha: 2024-12-11 con hora desde: 11:26:00 hasta: 12:27:00', 'yabe', 48),
(172, 'DELETE', 'root@localhost', '2024-12-07 11:29:10', 'Se eliminó el evento: Conferencia sobre Saluddd', 'yabe', 48),
(173, 'INSERT', 'root@localhost', '2024-12-07 11:33:25', 'Insertó un nuevo evento:  \" Charla de orientación a los estubdiantes hhhhhhhhh \" con fecha: 2024-12-10 con hora desde: 11:33:00 hasta: 13:33:00', NULL, 49),
(174, 'UPDATE', 'root@localhost', '2024-12-07 11:34:35', 'Nombre del evento cambiado de:\"Charla de orientación a los estubdiantes hhhhhhhhh\" a: \"Conferencia sobre Saluddd\". ', 'yabe', 49),
(175, 'DELETE', 'root@localhost', '2024-12-07 11:36:23', 'Se eliminó el evento: Conferencia sobre Saluddd', 'yabe', 49);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facultad`
--

CREATE TABLE `facultad` (
  `idfacultad` int(11) NOT NULL,
  `nomfac` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facultad`
--

INSERT INTO `facultad` (`idfacultad`, `nomfac`) VALUES
(1, 'Facultad de Ciencias'),
(2, 'Facultad de Ciencias Médicas'),
(3, 'Facultad de Ciencias Agrarias'),
(4, 'Facultad de Ingeniería de Minas, Geología y Metalurgia'),
(5, 'Facultad de Ingeniería Civil'),
(6, 'Facultad de Ingeniería de Industrias Alimentarias'),
(7, 'Facultad de Ciencias del Ambiente'),
(8, 'Facultad de Economía y Contabilidad'),
(9, 'Facultad de Administración y Turismo'),
(10, 'Facultad de Ciencias sociales, Educación y de la Comunicación'),
(11, 'Facultad de Derecho y Ciencias Políticas'),
(12, 'Facultad de Medicina');

--
-- Disparadores `facultad`
--
DELIMITER $$
CREATE TRIGGER `I_facu_D` BEFORE INSERT ON `facultad` FOR EACH ROW BEGIN
    DECLARE contar INT;
    SELECT COUNT(*) INTO contar
    FROM facultad
    WHERE nomfac = NEW.nomfac;

    IF contar > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Ya existe la facultad';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `U_facu_D` BEFORE UPDATE ON `facultad` FOR EACH ROW BEGIN
    DECLARE contar INT;
    SELECT COUNT(*) INTO contar
    FROM facultad
    WHERE nomfac = NEW.nomfac
    AND idfacultad != NEW.idfacultad;

    IF contar > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Ya existe la facultad';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `prevent_delete_facultad` BEFORE DELETE ON `facultad` FOR EACH ROW BEGIN  
    DECLARE count_related INT;  

    -- Contar cuántas filas en la tabla escuela están relacionadas con la facultad a eliminar  
    SELECT COUNT(*) INTO count_related  
    FROM escuela  
    WHERE idfacultad = OLD.idfacultad;  

    -- Verificar si existen filas relacionadas  
    IF count_related > 0 THEN  
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No se puede eliminar la facultad porque existen escuelas relacionadas.';  
    END IF;  
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

CREATE TABLE `generos` (
  `idgenero` int(11) NOT NULL,
  `nomgen` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`idgenero`, `nomgen`) VALUES
(1, 'Masculino'),
(2, 'Femenino');

--
-- Disparadores `generos`
--
DELIMITER $$
CREATE TRIGGER `I_generos` BEFORE INSERT ON `generos` FOR EACH ROW BEGIN
    DECLARE contar INT;
    SELECT COUNT(*) INTO contar
    FROM generos
    WHERE nomgen = NEW.nomgen;

    IF contar > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Ya existe el género';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `U_generos` BEFORE UPDATE ON `generos` FOR EACH ROW BEGIN
    DECLARE contar INT;
    SELECT COUNT(*) INTO contar
    FROM generos
    WHERE nomgen = NEW.nomgen
    AND idgenero != NEW.idgenero;

    IF contar > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Ya existe el género';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hola`
--

CREATE TABLE `hola` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `id` int(11) NOT NULL,
  `nombre_imagen` varchar(255) NOT NULL,
  `ruta_imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `imagenes`
--

INSERT INTO `imagenes` (`id`, `nombre_imagen`, `ruta_imagen`) VALUES
(8, '1730306859_web.jfif', 'uploads/1730306859_web.jfif');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informe`
--

CREATE TABLE `informe` (
  `idinforme` int(11) NOT NULL,
  `fecpres` date DEFAULT NULL,
  `rta` text NOT NULL,
  `idevento` int(11) NOT NULL,
  `idTipinfor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `informe`
--

INSERT INTO `informe` (`idinforme`, `fecpres`, `rta`, `idevento`, `idTipinfor`) VALUES
(1, '2024-10-16', 'informe/Modeloslógicos (1).pdf', 1, 1),
(2, '2024-10-16', 'informe/Modeloslógicos (1).pdf', 2, 1),
(5, '2024-10-17', 'informe/ARQUITECTURA DEL COMPUTADOR.pdf', 3, 1),
(6, '2024-10-16', 'informe/PREACTAS-2024-II.pdf', 4, 1),
(10, '2024-11-14', 'informe/Ficha de Inscripcion[1].pdf', 7, 3),
(11, '2024-12-01', 'informe/Sesion 21.pdf', 11, 5);

--
-- Disparadores `informe`
--
DELIMITER $$
CREATE TRIGGER `after_informe_delete` AFTER DELETE ON `informe` FOR EACH ROW BEGIN
    INSERT INTO informe_auditoria (
        operacion, 
        usuario, 
        fecha_operacion, 
        fecha_presentacion, 
        rta, 
        idevento, 
        idoriginal
    ) VALUES (
        'DELETE', 
        USER(), 
        CURRENT_TIMESTAMP, 
        OLD.fecpres, 
        OLD.rta, 
        OLD.idevento, 
        OLD.idinforme
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_informe_insert` AFTER INSERT ON `informe` FOR EACH ROW BEGIN
    INSERT INTO informe_auditoria (
        operacion, 
        usuario, 
        fecha_operacion, 
        fecha_presentacion, 
        rta, 
        idevento, 
        idoriginal
    ) VALUES (
        'INSERT', 
        USER(), 
        CURRENT_TIMESTAMP, 
        NEW.fecpres, 
        NEW.rta, 
        NEW.idevento, 
        NEW.idinforme
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_informe_update` AFTER UPDATE ON `informe` FOR EACH ROW BEGIN
    INSERT INTO informe_auditoria (
        operacion, 
        usuario, 
        fecha_operacion, 
        fecha_presentacion, 
        rta, 
        idevento,  
        idoriginal
    ) VALUES (
        'UPDATE', 
        USER(), 
        CURRENT_TIMESTAMP, 
        NEW.fecpres, 
        NEW.rta, 
        NEW.idevento, 
        OLD.idinforme
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informe_auditoria`
--

CREATE TABLE `informe_auditoria` (
  `id_audit` int(11) NOT NULL,
  `operacion` varchar(10) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `fecha_operacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_presentacion` datetime DEFAULT NULL,
  `rta` text DEFAULT NULL,
  `idevento` int(11) DEFAULT NULL,
  `nombreusuario` varchar(50) DEFAULT NULL,
  `idoriginal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `informe_auditoria`
--

INSERT INTO `informe_auditoria` (`id_audit`, `operacion`, `usuario`, `fecha_operacion`, `fecha_presentacion`, `rta`, `idevento`, `nombreusuario`, `idoriginal`) VALUES
(6, 'UPDATE', 'root@localhost', '2024-11-16 16:53:27', '2024-10-23 00:00:00', 'informe/PROYECTO DE BD.pdf', 5, 'yabe', 7),
(7, 'DELETE', 'root@localhost', '2024-11-16 16:56:42', '2024-10-23 00:00:00', 'informe/PROYECTO DE BD.pdf', 5, 'yabe', 7),
(8, 'INSERT', 'root@localhost', '2024-11-16 18:57:45', '2024-11-14 00:00:00', 'informe/Ficha de Inscripcion[1].pdf', 7, 'yabe', 10),
(9, 'INSERT', 'root@localhost', '2024-12-05 20:45:05', '2024-12-01 00:00:00', 'informe/Sesion 21.pdf', 11, 'Kath', 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion`
--

CREATE TABLE `inscripcion` (
  `idincrip` int(11) NOT NULL,
  `idescuela` int(11) NOT NULL,
  `idpersona` int(11) NOT NULL,
  `idevento` int(11) NOT NULL,
  `fecinscripcion` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inscripcion`
--

INSERT INTO `inscripcion` (`idincrip`, `idescuela`, `idpersona`, `idevento`, `fecinscripcion`) VALUES
(1, 1, 1, 1, '2024-10-30'),
(2, 2, 2, 1, '2024-10-30'),
(3, 3, 3, 1, '2024-10-30'),
(4, 3, 4, 3, '2024-10-30'),
(5, 3, 5, 3, '2024-10-30'),
(6, 2, 6, 4, '2024-10-30'),
(7, 7, 7, 5, '2024-10-30'),
(8, 4, 8, 6, '2024-10-30'),
(9, 5, 9, 7, '2024-10-30'),
(10, 9, 10, 8, '2024-10-30'),
(11, 2, 11, 9, '2024-10-30'),
(12, 4, 12, 10, '2024-10-09'),
(13, 5, 13, 11, '2024-10-30'),
(14, 1, 14, 12, '2024-10-30'),
(15, 3, 15, 13, '2024-10-30'),
(16, 3, 18, 12, '2024-10-30'),
(17, 19, 19, 12, '2024-10-30'),
(19, 3, 20, 4, '2024-10-31'),
(20, 1, 19, 4, '2024-10-31'),
(21, 1, 18, 43, '2024-11-14'),
(22, 1, 18, 6, '2024-11-16'),
(23, 1, 21, 6, '2024-11-16'),
(24, 16, 22, 6, '2024-11-16'),
(25, 17, 23, 6, '2024-11-16'),
(26, 1, 24, 6, '2024-11-16'),
(27, 18, 25, 6, '2024-11-16'),
(28, 1, 26, 6, '2024-11-16'),
(29, 16, 27, 6, '2024-11-16'),
(30, 14, 28, 6, '2024-11-16'),
(31, 17, 29, 6, '2024-11-16'),
(32, 1, 30, 6, '2024-11-16'),
(33, 1, 18, 8, '2024-11-16'),
(34, 1, 18, 47, '2024-12-06'),
(35, 1, 31, 47, '2024-12-06'),
(36, 1, 18, 34, '2024-12-07'),
(37, 22, 18, 23, '2024-12-07'),
(38, 8, 18, 27, '2024-12-07'),
(39, 1, 18, 39, '2024-12-07');

--
-- Disparadores `inscripcion`
--
DELIMITER $$
CREATE TRIGGER `inscripcion_after_delete` AFTER DELETE ON `inscripcion` FOR EACH ROW BEGIN
  DECLARE nombre_usuario VARCHAR(50);
  SET nombre_usuario = @usuario_logueado;
  INSERT INTO inscripcion_audit (operation, idincrip, idescuela, idpersona, idevento, fecinscripcion, modified_at, nomusu, usuario)
  VALUES ('DELETE', OLD.idincrip, OLD.idescuela, OLD.idpersona, OLD.idevento, OLD.fecinscripcion, NOW(), nombre_usuario, USER());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `inscripcion_after_insert` AFTER INSERT ON `inscripcion` FOR EACH ROW BEGIN
  DECLARE nombre_usuario VARCHAR(50);

  SET nombre_usuario = @usuario_logueado;

  INSERT INTO inscripcion_audit (operation, idincrip, idescuela, idpersona, idevento, fecinscripcion, modified_at, nomusu, usuario)
  VALUES ('INSERT', NEW.idincrip, NEW.idescuela, NEW.idpersona, NEW.idevento, NEW.fecinscripcion, NOW(), nombre_usuario, USER());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `inscripcion_after_update` AFTER UPDATE ON `inscripcion` FOR EACH ROW BEGIN
  DECLARE nombre_usuario VARCHAR(50);
  SET nombre_usuario = @usuario_logueado;

  INSERT INTO inscripcion_audit (operation, idincrip, idescuela, idpersona, idevento, fecinscripcion, modified_at, nomusu, usuario)
  VALUES ('UPDATE', NEW.idincrip, NEW.idescuela, NEW.idpersona, NEW.idevento, NEW.fecinscripcion, NOW(), nombre_usuario, USER());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion_audit`
--

CREATE TABLE `inscripcion_audit` (
  `audit_id` int(11) NOT NULL,
  `operation` enum('INSERT','UPDATE','DELETE') NOT NULL,
  `idincrip` int(11) NOT NULL,
  `idescuela` int(11) DEFAULT NULL,
  `idpersona` int(11) DEFAULT NULL,
  `idevento` int(11) DEFAULT NULL,
  `fecinscripcion` date DEFAULT NULL,
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `nomusu` varchar(50) DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inscripcion_audit`
--

INSERT INTO `inscripcion_audit` (`audit_id`, `operation`, `idincrip`, `idescuela`, `idpersona`, `idevento`, `fecinscripcion`, `modified_at`, `nomusu`, `usuario`) VALUES
(1, 'INSERT', 22, 1, 18, 6, '2024-11-16', '2024-11-16 19:45:35', 'yabe', 'root@localhost'),
(2, 'INSERT', 23, 1, 21, 6, '2024-11-16', '2024-11-16 20:45:12', 'yabe', 'root@localhost'),
(3, 'INSERT', 24, 16, 22, 6, '2024-11-16', '2024-11-16 20:45:52', 'yabe', 'root@localhost'),
(4, 'INSERT', 25, 17, 23, 6, '2024-11-16', '2024-11-16 20:46:19', 'yabe', 'root@localhost'),
(5, 'INSERT', 26, 1, 24, 6, '2024-11-16', '2024-11-16 20:46:58', 'yabe', 'root@localhost'),
(6, 'INSERT', 27, 18, 25, 6, '2024-11-16', '2024-11-16 20:47:37', 'yabe', 'root@localhost'),
(7, 'INSERT', 28, 1, 26, 6, '2024-11-16', '2024-11-16 20:48:08', 'yabe', 'root@localhost'),
(8, 'INSERT', 29, 16, 27, 6, '2024-11-16', '2024-11-16 20:48:43', 'yabe', 'root@localhost'),
(9, 'INSERT', 30, 14, 28, 6, '2024-11-16', '2024-11-16 20:49:14', 'yabe', 'root@localhost'),
(10, 'INSERT', 31, 17, 29, 6, '2024-11-16', '2024-11-16 20:49:43', 'yabe', 'root@localhost'),
(11, 'INSERT', 32, 1, 30, 6, '2024-11-16', '2024-11-16 20:51:13', 'yabe', 'root@localhost'),
(12, 'INSERT', 33, 1, 18, 8, '2024-11-16', '2024-11-17 02:45:02', 'yabe', 'root@localhost'),
(13, 'INSERT', 34, 1, 18, 47, '2024-12-06', '2024-12-07 00:43:11', 'yabe', 'root@localhost'),
(14, 'INSERT', 35, 1, 31, 47, '2024-12-06', '2024-12-07 00:48:00', 'yabe', 'root@localhost'),
(15, 'INSERT', 36, 1, 18, 34, '2024-12-07', '2024-12-07 16:04:47', 'yabe', 'root@localhost'),
(16, 'INSERT', 37, 3, 18, 23, '2024-12-07', '2024-12-07 16:21:07', NULL, 'root@localhost'),
(17, 'INSERT', 38, 8, 18, 27, '2024-12-07', '2024-12-07 16:21:42', NULL, 'root@localhost'),
(18, 'INSERT', 39, 1, 18, 39, '2024-12-07', '2024-12-07 16:22:35', 'yabe', 'root@localhost'),
(19, 'UPDATE', 37, 22, 18, 23, '2024-12-07', '2024-12-07 16:25:33', 'yabe', 'root@localhost');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `nombre_ruta` varchar(45) NOT NULL,
  `nombre_permiso` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `nombre_ruta`, `nombre_permiso`) VALUES
(1, 'Rut.evento', 'Evento'),
(2, 'tipo.evento', 'Tipo de Evento'),
(3, 'Rut.reso', 'Resolucion de Evento'),
(4, 'Rut.inscri', 'Inscripcion de Participantes'),
(5, 'Rut.asistenc', 'Asistencias'),
(6, 'Rut-certi', 'Certificado'),
(7, 'Rut.infor', 'Informe de Certificados'),
(8, 'Rut.facu', 'Facultad'),
(9, 'Rut.escu', 'Escuela'),
(10, 'Vtareport', 'Reportes'),
(11, 'Rutususario', 'Usuario'),
(12, 'Rutususario.per', 'Datos de Usuario'),
(13, 'Rut.tipreso', 'Tipo de Resolucion'),
(14, 'Rut.tipusu', 'Tipo de Usuario'),
(15, 'auditorias', 'Auditoria'),
(16, 'Rut.tipinfo', 'Tipo de Informe');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `idpersona` int(11) NOT NULL,
  `dni` varchar(8) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apell` varchar(45) NOT NULL,
  `tele` varchar(11) NOT NULL,
  `email` varchar(45) NOT NULL,
  `direc` varchar(45) NOT NULL,
  `idgenero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`idpersona`, `dni`, `nombre`, `apell`, `tele`, `email`, `direc`, `idgenero`) VALUES
(1, '12345678', 'Juan', 'Pérez', '987654321', 'juan.perez@example.com', 'Av. Los Olivos 123', 1),
(2, '87654321', 'María', 'Gómez', '998877665', 'maria.gomez@example.com', 'Jr. Las Flores 456', 2),
(3, '11223344', 'Carlos', 'Lopez', '965432178', 'carlos.lopez@example.com', 'Av. La Paz 789', 1),
(4, '44332211', 'Ana', 'Martinez', '988776655', 'ana.martinez@example.com', 'Calle San Juan 321', 2),
(5, '33445566', 'José', 'Ramírez', '911223344', 'jose.ramirez@example.com', 'Av. Los Jazmines 567', 1),
(6, '66778899', 'Lucía', 'Fernández', '922334455', 'luciafernandez@example.com', 'Jr. El Sol 890', 2),
(7, '55667788', 'David', 'García', '933445566', 'davidgarcia@example.com', 'Av. La Libertad 234', 1),
(8, '99887766', 'Sofía', 'Reyes', '944556677', 'sofiareyes@example.com', 'Calle Santa Rosa 678', 2),
(9, '12349876', 'Miguel', 'Torres', '955667788', 'migueltorres@example.com', 'Av. Los Pinos 123', 1),
(10, '87651234', 'Elena', 'Vásquez', '966778899', 'elenavasquez@example.com', 'Jr. La Esperanza 456', 2),
(11, '65432109', 'Fernando', 'Cruz', '977889900', 'fernando.cruz@example.com', 'Calle La Unión 789', 1),
(12, '98765432', 'Valeria', 'Mendoza', '988990011', 'valeria.mendoza@example.com', 'Av. Las Palmeras 101', 2),
(13, '12345679', 'Ricardo', 'Soto', '999900011', 'ricardo.soto@example.com', 'Jr. La Amistad 202', 1),
(14, '11223345', 'Patricia', 'Silva', '910123456', 'patricia.silva@example.com', 'Av. Los Rosales 303', 2),
(15, '99887765', 'Jorge', 'Castillo', '901234567', 'jorge.castillo@example.com', 'Calle Los Abetos 404', 1),
(16, '22200089', 'Yurlin', 'Jaramillo Pinedo', '999999887', 'iudhfej@gmail.com', 'Huaraz', 2),
(17, '44435691', 'Fran Erick', 'Inti Coral', '980765321', 'franc@gmail.com', 'Cerro', 1),
(18, '73473596', 'Yabeth', 'Cueva Sanchez', '999999999', 'Yabeth@gmail.com', 'Huaraz', 2),
(19, '75451722', 'Jean Paul', 'Blas Avila', '928539012', 'Jeanblas@gmail.com', 'Pasaje Los Olivos', 1),
(20, '77902955', 'Katherine', 'Aranibar Rondan', '928539012', 'kat03aranibar@gmail.com', 'Shancayan', 2),
(21, '11111111', 'dfjjsdh', 'jhsjhs', '98765438', 'yabethcuevasanchez@gmail.com', 'Huari', 2),
(22, '22222222', 'Gómez Laura', 'jonceano hoidalgo', '98765436', 'yojarcuevasanchez@gmail.com', 'Calle Sol 101', 1),
(23, '33333333', 'Perez Juan', 'yauri vidal', '98765436', 'ana.martinez@example.com', 'Calle Sol 101', 2),
(24, '44444444', 'yabeth', 'Huerta cueva', '925390577', 'yojarcuevasanchez@gmail.com', 'esquina', 2),
(25, '66666666', 'yabeth', 'Martínez', '98765436', 'ana.martinez@example.com', 'esquina', 1),
(26, '88888888', 'yabeth', 'Huerta cueva', '98765433', 'yojarcuevasanchez@gmail.com', 'Huaraz', 1),
(27, '55555555', 'Gómez Laura', 'Martínez', '925390577', 'ana.martinez@example.com', 'Calle Sol 101', 1),
(28, '99999999', 'Perez Juan', 'Martínez', '987654324', 'yojarcuevasanchez@gmail.com', 'Calle Sol 101', 2),
(29, '00000000', 'Perez Juan', 'Huerta cueva', '98765436', 'ana.martinez@example.com', 'Huaraz', 2),
(30, '43567890', 'Gómez Laura', 'Huerta cueva', '925390577', 'ana.martinez@example.com', 'Calle Sol 101', 2),
(31, '73473590', 'Perez Juan', 'jonceano hoidalgo', '999999999', 'yojarcuevasanchez@gmail.com', 'av.eucalip', 2);

--
-- Disparadores `personas`
--
DELIMITER $$
CREATE TRIGGER `Idni_solo_num` BEFORE INSERT ON `personas` FOR EACH ROW BEGIN
    IF NOT NEW.dni REGEXP '^[0-9]+$' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El campo de DNI debe contener únicamente números.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Itele_solo_num` BEFORE INSERT ON `personas` FOR EACH ROW BEGIN
    IF NOT NEW.tele REGEXP '^[0-9]+$' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El campo de teléfono debe contener únicamente números.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Udni_solo_num` BEFORE UPDATE ON `personas` FOR EACH ROW BEGIN
    IF NOT NEW.dni REGEXP '^[0-9]+$' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El campo de DNI debe contener únicamente números.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Utele_solo_num` BEFORE UPDATE ON `personas` FOR EACH ROW BEGIN
    IF NOT NEW.tele REGEXP '^[0-9]+$' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El campo de teléfono debe contener únicamente números.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `rep_P_Mod` BEFORE UPDATE ON `personas` FOR EACH ROW BEGIN
    DECLARE contar INT;
    SELECT COUNT(*)
    INTO contar
    FROM personas
    WHERE dni = NEW.dni AND idpersona <> OLD.idpersona;
    IF contar > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Ya existe una persona registrada con el mismo DNI.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `repetir_P` BEFORE INSERT ON `personas` FOR EACH ROW BEGIN
    DECLARE contar INT;
    SELECT COUNT(*)
    INTO contar
    FROM personas
    WHERE dni = NEW.dni;
    IF contar > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Ya existe una persona registrada con el mismo DNI.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resoluciaprob`
--

CREATE TABLE `resoluciaprob` (
  `idreslaprb` int(11) NOT NULL,
  `nrores` varchar(45) NOT NULL,
  `fechapro` date DEFAULT NULL,
  `idTipresol` int(11) NOT NULL,
  `idevento` int(11) NOT NULL,
  `ruta` text NOT NULL,
  `fecharegist` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resoluciaprob`
--

INSERT INTO `resoluciaprob` (`idreslaprb`, `nrores`, `fechapro`, `idTipresol`, `idevento`, `ruta`, `fecharegist`) VALUES
(35, '7632746', '2024-12-03', 1, 1, 'resoluciaprob/Sesion 21.pdf', '2024-12-05'),
(37, 'hgjhghj', '2024-12-01', 1, 5, 'resoluciaprob/proyecto-cid.docx', '2024-12-05'),
(39, 'hgjhgh90', '2024-12-01', 1, 11, 'resoluciaprob/Sesion 21.pdf', '2024-12-05'),
(40, 'hgjhghjj', '2024-10-29', 1, 4, 'resoluciaprob/Sesion 21.pdf', '2024-12-05'),
(41, 'hgjhghj99', '2024-10-28', 1, 10, 'resoluciaprob/seccion 3 CRITERIOS-EJEMPLO.pdf', '2024-12-05'),
(42, 'fdsfsss4', '2024-12-01', 2, 6, 'resoluciaprob/Sesion 21.pdf', '2024-12-05'),
(43, 'hgjhghj66', '2024-10-28', 2, 9, 'resoluciaprob/Componente Léxico.pdf', '2024-12-05'),
(44, '763274677', '2024-12-01', 1, 7, 'resoluciaprob/Sesion 21.pdf', '2024-12-05'),
(45, 'fdsfssshh', '2024-12-01', 2, 8, 'resoluciaprob/tony.pdf', '2024-12-05'),
(46, 'hgjhghj88', '2024-12-01', 2, 3, 'resoluciaprob/PROYECTO DE BD.pdf', '2024-12-05'),
(47, '7632746777', '2024-12-01', 1, 12, 'resoluciaprob/Anexo A - Identificación de Requerimientos del Sistemas – CIP.pdf', '2024-12-05'),
(48, '7632746', '2024-12-01', 2, 14, 'resoluciaprob/solicitud.docx', '2024-12-05'),
(49, '7632746', '2024-12-01', 1, 47, 'resoluciaprob/LINEAS DE ESPERA.pdf', '2024-12-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('rxb0hzaToTOm3LerKIbqYtxndjwtHCd5pzPwd5oE', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidTVNR3Nia1ZmWkpVb0VlaXR2MzQxNXJuVjlhSWZiVHpTY1lxZHlmUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTg6Imh0dHA6Ly9sb2NhbGhvc3QvZXZlbi9sYXJhdmVsMTEvcHVibGljL2V2ZW50b3MtY29uLWluZm9ybWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1730301908),
('e7W2bEPuE89v4FktOthtLDMINXgCsKrP6mRlktKO', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiQkRvR2lvS0s4eUl2WjVITEpIdTdWZWZkeHNaM3F3dzVLd1NUNHI3TCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1730389618);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoasiste`
--

CREATE TABLE `tipoasiste` (
  `idtipasis` int(11) NOT NULL,
  `nomasis` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipoasiste`
--

INSERT INTO `tipoasiste` (`idtipasis`, `nomasis`) VALUES
(1, 'Presente'),
(2, 'Ausente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoasistencia`
--

CREATE TABLE `tipoasistencia` (
  `idestado` int(11) NOT NULL,
  `tipoasisten` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipoasistencia`
--

INSERT INTO `tipoasistencia` (`idestado`, `tipoasisten`) VALUES
(1, 'pendiente'),
(2, 'culminado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoevento`
--

CREATE TABLE `tipoevento` (
  `idTipoeven` int(11) NOT NULL,
  `nomeven` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipoevento`
--

INSERT INTO `tipoevento` (`idTipoeven`, `nomeven`) VALUES
(1, 'Conferencia Académica'),
(2, 'Taller de Investigación'),
(3, 'Seminario de Especialización'),
(4, 'Exposición de Proyectos'),
(5, 'Feria de Emprendimiento'),
(6, 'Charla Motivacional'),
(7, 'Reunión de Estudiantes'),
(8, 'Festival Cultural'),
(9, 'Cine Fórum Educativo'),
(10, 'Foro de Discusión'),
(11, 'Jornada de Capacitación'),
(12, 'Taller de Habilidades Blandas'),
(13, 'Mesa Redonda'),
(14, 'Simposio Científico'),
(15, 'Presentación de Tesis');

--
-- Disparadores `tipoevento`
--
DELIMITER $$
CREATE TRIGGER `I_tipevento` BEFORE INSERT ON `tipoevento` FOR EACH ROW BEGIN
    DECLARE contar INT;
    SELECT COUNT(*) INTO contar
    FROM Tipoevento
    WHERE nomeven = NEW.nomeven;

    IF contar > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Ya existe el tipo de evento';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `U_tipevento` BEFORE UPDATE ON `tipoevento` FOR EACH ROW BEGIN
    DECLARE contar INT;
    SELECT COUNT(*) INTO contar
    FROM Tipoevento
    WHERE nomeven = NEW.nomeven
    AND idTipoeven != NEW.idTipoeven;

    IF contar > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Ya existe el tipo de evento';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `elimifktipeven` BEFORE DELETE ON `tipoevento` FOR EACH ROW BEGIN
    IF (SELECT COUNT(*) FROM evento WHERE idTipoeven = OLD.idTipoeven) > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'No se puede eliminar el tipo de evento porque está asociado a uno o más eventos.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoinforme`
--

CREATE TABLE `tipoinforme` (
  `idTipinfor` int(11) NOT NULL,
  `nomtinform` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipoinforme`
--

INSERT INTO `tipoinforme` (`idTipinfor`, `nomtinform`) VALUES
(1, 'informe'),
(3, 'Tipo 1'),
(4, 'tipo 2'),
(5, 'tipo 3'),
(9, 'Tipo 4');

--
-- Disparadores `tipoinforme`
--
DELIMITER $$
CREATE TRIGGER `deletetipoinforme` BEFORE DELETE ON `tipoinforme` FOR EACH ROW BEGIN
    IF EXISTS (SELECT 1 FROM informe WHERE idTipinfor = OLD.idTipinfor) THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'No se puede eliminar el tipo de informe porque existen registros relacionados';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiporesolucion`
--

CREATE TABLE `tiporesolucion` (
  `idTipresol` int(11) NOT NULL,
  `nomtiprs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tiporesolucion`
--

INSERT INTO `tiporesolucion` (`idTipresol`, `nomtiprs`) VALUES
(1, 'Aprobado'),
(2, 'Desaprobado'),
(5, 'hdgf<dsgf');

--
-- Disparadores `tiporesolucion`
--
DELIMITER $$
CREATE TRIGGER `I_tiporesolu` BEFORE INSERT ON `tiporesolucion` FOR EACH ROW BEGIN
    DECLARE contar INT;
    SELECT COUNT(*) INTO contar
    FROM TipoResolucion
    WHERE nomtiprs = NEW.nomtiprs;

    IF contar > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Ya existe el tipo de resolución';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `PreventDeleteTipoResolucion` BEFORE DELETE ON `tiporesolucion` FOR EACH ROW BEGIN  
    DECLARE tipoExistente INT;  
    SELECT COUNT(*) INTO tipoExistente   
    FROM resoluciaprob   
    WHERE idTipresol = OLD.idTipresol;  

    IF tipoExistente > 0 THEN  
        SIGNAL SQLSTATE '45000'  
        SET MESSAGE_TEXT = 'No se puede eliminar el tipo de resolución';  
    END IF;  
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `U_tipoResolu` BEFORE UPDATE ON `tiporesolucion` FOR EACH ROW BEGIN
    DECLARE contar INT;
    SELECT COUNT(*) INTO contar
    FROM TipoResolucion
    WHERE nomtiprs = NEW.nomtiprs
    AND idTipresol != NEW.idTipresol;

    IF contar > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Ya existe el tipo de resolución';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipousuario`
--

CREATE TABLE `tipousuario` (
  `idTipUsua` int(11) NOT NULL,
  `tipousu` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipousuario`
--

INSERT INTO `tipousuario` (`idTipUsua`, `tipousu`) VALUES
(1, 'Administrador'),
(2, 'secretaria'),
(6, 'berberbenr');

--
-- Disparadores `tipousuario`
--
DELIMITER $$
CREATE TRIGGER `ELItipousuario` BEFORE DELETE ON `tipousuario` FOR EACH ROW BEGIN  
    DECLARE conteo INT;  
    SELECT COUNT(*) INTO conteo  
    FROM usuario  
    WHERE idTipUsua = OLD.idTipUsua;  
    IF conteo > 0 THEN  
        SIGNAL SQLSTATE '45000'  
            SET MESSAGE_TEXT = 'No se puede eliminar el tipo de usuario';  
    END IF;  
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `In_tipo_I` BEFORE INSERT ON `tipousuario` FOR EACH ROW BEGIN
    DECLARE contar INT;
    SELECT COUNT(*) INTO contar
    FROM TipoUsuario
    WHERE tipousu = NEW.tipousu;
    IF contar > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Ya existe el tipo de usuario';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `In_tipo_U` BEFORE UPDATE ON `tipousuario` FOR EACH ROW BEGIN
    DECLARE contar INT;
    SELECT COUNT(*) INTO contar
    FROM TipoUsuario
    WHERE tipousu = NEW.tipousu
    AND idTipUsua != NEW.idTipUsua;

    IF contar > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Ya existe el tipo de usuario';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nomusu` varchar(45) NOT NULL,
  `pasword` varchar(45) NOT NULL,
  `idTipUsua` int(11) NOT NULL,
  `ubigeo` varchar(200) DEFAULT NULL,
  `fechaemision` date DEFAULT NULL,
  `dniu` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nomusu`, `pasword`, `idTipUsua`, `ubigeo`, `fechaemision`, `dniu`) VALUES
(42, 'Kath', '6095c9e151f8d59cf6b2ee83a386e0bb', 1, 'e4a3cba4b543f137b27b81e9f3f7d90c', '2022-10-28', '77902955'),
(45, 'Yurlin', '56fcf2983328866650d583541b9ddf39', 2, NULL, NULL, ''),
(48, 'Daniel', '262031397020fd8df478ec13b4b096c5', 6, '839e9c1a49e7ebdeddf258630a89a2bc', '2021-01-05', ''),
(56, 'yabe', 'ca1436f91329cd8a3ad6b679d010849c', 1, '7bac4b4f29790689dbf56c680a3a204c', '2024-11-03', '73473596');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_permisos`
--

CREATE TABLE `usuario_permisos` (
  `idusuariopermiso` int(11) NOT NULL,
  `usuario_idusuario` int(11) NOT NULL,
  `permiso_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_permisos`
--

INSERT INTO `usuario_permisos` (`idusuariopermiso`, `usuario_idusuario`, `permiso_id`) VALUES
(3, 42, 1),
(4, 42, 2),
(5, 42, 3),
(6, 42, 11),
(11, 42, 4),
(12, 42, 5),
(14, 42, 7),
(15, 42, 8),
(16, 42, 9),
(17, 42, 10),
(18, 42, 12),
(19, 42, 13),
(20, 42, 14),
(21, 42, 15),
(24, 42, 6),
(26, 45, 1),
(27, 42, 16),
(28, 48, 11),
(46, 56, 1),
(47, 56, 2),
(48, 56, 3),
(49, 56, 4),
(50, 56, 5),
(51, 56, 6),
(52, 56, 7),
(53, 56, 8),
(54, 56, 9),
(55, 56, 10),
(56, 56, 11),
(57, 56, 12),
(58, 56, 13),
(59, 56, 14),
(60, 56, 15),
(61, 56, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vista_tipeven`
--

CREATE TABLE `vista_tipeven` (
  `nomeven` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`idasistnc`),
  ADD KEY `idestado` (`idestado`);

--
-- Indices de la tabla `asistencia_audit`
--
ALTER TABLE `asistencia_audit`
  ADD PRIMARY KEY (`audit_id`);

--
-- Indices de la tabla `certificacion`
--
ALTER TABLE `certificacion`
  ADD PRIMARY KEY (`idcertificacn`);

--
-- Indices de la tabla `certificado`
--
ALTER TABLE `certificado`
  ADD PRIMARY KEY (`idCertif`),
  ADD KEY `idcertificacn` (`idcertificacn`);

--
-- Indices de la tabla `certificado_auditoria`
--
ALTER TABLE `certificado_auditoria`
  ADD PRIMARY KEY (`id_audit`);

--
-- Indices de la tabla `datosperusu`
--
ALTER TABLE `datosperusu`
  ADD PRIMARY KEY (`idatosPer`);

--
-- Indices de la tabla `escuela`
--
ALTER TABLE `escuela`
  ADD PRIMARY KEY (`idescuela`);

--
-- Indices de la tabla `estadocerti`
--
ALTER TABLE `estadocerti`
  ADD PRIMARY KEY (`idestcer`);

--
-- Indices de la tabla `estadoevento`
--
ALTER TABLE `estadoevento`
  ADD PRIMARY KEY (`idestadoeve`);

--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`idevento`);

--
-- Indices de la tabla `evento_auditoria`
--
ALTER TABLE `evento_auditoria`
  ADD PRIMARY KEY (`id_audit`);

--
-- Indices de la tabla `facultad`
--
ALTER TABLE `facultad`
  ADD PRIMARY KEY (`idfacultad`);

--
-- Indices de la tabla `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`idgenero`);

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `informe`
--
ALTER TABLE `informe`
  ADD PRIMARY KEY (`idinforme`),
  ADD KEY `idevento` (`idevento`),
  ADD KEY `fk_idTipinfor` (`idTipinfor`);

--
-- Indices de la tabla `informe_auditoria`
--
ALTER TABLE `informe_auditoria`
  ADD PRIMARY KEY (`id_audit`);

--
-- Indices de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD PRIMARY KEY (`idincrip`);

--
-- Indices de la tabla `inscripcion_audit`
--
ALTER TABLE `inscripcion_audit`
  ADD PRIMARY KEY (`audit_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`idpersona`);

--
-- Indices de la tabla `resoluciaprob`
--
ALTER TABLE `resoluciaprob`
  ADD PRIMARY KEY (`idreslaprb`);

--
-- Indices de la tabla `tipoasiste`
--
ALTER TABLE `tipoasiste`
  ADD PRIMARY KEY (`idtipasis`);

--
-- Indices de la tabla `tipoasistencia`
--
ALTER TABLE `tipoasistencia`
  ADD PRIMARY KEY (`idestado`);

--
-- Indices de la tabla `tipoevento`
--
ALTER TABLE `tipoevento`
  ADD PRIMARY KEY (`idTipoeven`);

--
-- Indices de la tabla `tipoinforme`
--
ALTER TABLE `tipoinforme`
  ADD PRIMARY KEY (`idTipinfor`);

--
-- Indices de la tabla `tiporesolucion`
--
ALTER TABLE `tiporesolucion`
  ADD PRIMARY KEY (`idTipresol`);

--
-- Indices de la tabla `tipousuario`
--
ALTER TABLE `tipousuario`
  ADD PRIMARY KEY (`idTipUsua`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

--
-- Indices de la tabla `usuario_permisos`
--
ALTER TABLE `usuario_permisos`
  ADD PRIMARY KEY (`idusuariopermiso`),
  ADD KEY `FK_idusu` (`usuario_idusuario`),
  ADD KEY `FK_idpermi` (`permiso_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `idasistnc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `asistencia_audit`
--
ALTER TABLE `asistencia_audit`
  MODIFY `audit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `certificacion`
--
ALTER TABLE `certificacion`
  MODIFY `idcertificacn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `certificado`
--
ALTER TABLE `certificado`
  MODIFY `idCertif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `certificado_auditoria`
--
ALTER TABLE `certificado_auditoria`
  MODIFY `id_audit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de la tabla `datosperusu`
--
ALTER TABLE `datosperusu`
  MODIFY `idatosPer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `escuela`
--
ALTER TABLE `escuela`
  MODIFY `idescuela` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `estadocerti`
--
ALTER TABLE `estadocerti`
  MODIFY `idestcer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estadoevento`
--
ALTER TABLE `estadoevento`
  MODIFY `idestadoeve` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `idevento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `evento_auditoria`
--
ALTER TABLE `evento_auditoria`
  MODIFY `id_audit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT de la tabla `facultad`
--
ALTER TABLE `facultad`
  MODIFY `idfacultad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `generos`
--
ALTER TABLE `generos`
  MODIFY `idgenero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `informe`
--
ALTER TABLE `informe`
  MODIFY `idinforme` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `informe_auditoria`
--
ALTER TABLE `informe_auditoria`
  MODIFY `id_audit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `idincrip` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `inscripcion_audit`
--
ALTER TABLE `inscripcion_audit`
  MODIFY `audit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `idpersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `resoluciaprob`
--
ALTER TABLE `resoluciaprob`
  MODIFY `idreslaprb` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `tipoasiste`
--
ALTER TABLE `tipoasiste`
  MODIFY `idtipasis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipoasistencia`
--
ALTER TABLE `tipoasistencia`
  MODIFY `idestado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipoevento`
--
ALTER TABLE `tipoevento`
  MODIFY `idTipoeven` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `tipoinforme`
--
ALTER TABLE `tipoinforme`
  MODIFY `idTipinfor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tiporesolucion`
--
ALTER TABLE `tiporesolucion`
  MODIFY `idTipresol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tipousuario`
--
ALTER TABLE `tipousuario`
  MODIFY `idTipUsua` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `usuario_permisos`
--
ALTER TABLE `usuario_permisos`
  MODIFY `idusuariopermiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD CONSTRAINT `idestado` FOREIGN KEY (`idestado`) REFERENCES `tipoasistencia` (`idestado`);

--
-- Filtros para la tabla `certificado`
--
ALTER TABLE `certificado`
  ADD CONSTRAINT `idcertificacn` FOREIGN KEY (`idcertificacn`) REFERENCES `certificacion` (`idcertificacn`);

--
-- Filtros para la tabla `informe`
--
ALTER TABLE `informe`
  ADD CONSTRAINT `fk_idTipinfor` FOREIGN KEY (`idTipinfor`) REFERENCES `tipoinforme` (`idTipinfor`),
  ADD CONSTRAINT `idevento` FOREIGN KEY (`idevento`) REFERENCES `evento` (`idevento`);

--
-- Filtros para la tabla `usuario_permisos`
--
ALTER TABLE `usuario_permisos`
  ADD CONSTRAINT `FK_idpermi` FOREIGN KEY (`permiso_id`) REFERENCES `permisos` (`id`),
  ADD CONSTRAINT `FK_idusu` FOREIGN KEY (`usuario_idusuario`) REFERENCES `usuario` (`idusuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
