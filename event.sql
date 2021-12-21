-- Procedure nueva factura
DELIMITER //
CREATE PROCEDURE nuevaFactura()

BEGIN
DECLARE hihaerror BOOL;
DECLARE locDataInici DATE;
DECLARE locDataFin DATE;
DECLARE locImport INTEGER;
DECLARE locIdContracte INTEGER;
DECLARE locNomTarifa VARCHAR(15);
DECLARE locPeriodicitat INTEGER;
DECLARE pagaHoy CURSOR FOR SELECT dataFinal, import, IdContracte FROM factura WHERE dataFinal = CURRENT_DATE;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET hihaerror=true;
  OPEN pagaHoy;
  etiq: LOOP
	FETCH pagaHoy INTO locDataInici, locImport, locIdContracte;
    IF hihaerror THEN
    	LEAVE etiq;
    END IF;
    SELECT periodicitat INTO locPeriodicitat FROM contracte JOIN tarifa ON contracte.IdContracte = locIdContracte AND contracte.nomTarifa = tarifa.nomTarifa;
    INSERT INTO factura(dataInici,dataFinal,dataPagament,import,IdContracte) VALUES (locDataInici,date_add(now(),INTERVAL locPeriodicitat DAY ),null,locImport,locIdContracte);
	END LOOP;
    CLOSE pagaHoy;
END
-------------------------------------------------------------------------------------------------
SET GLOBAL event_scheduler = ON;
-------------------------------------------------------------------------------------------------

-- Trigger nueva factura
DELIMITER //

CREATE EVENT facturacio

ON SCHEDULE
  EVERY 1 DAY
    STARTS '2021-12-19 03:00:00' ON COMPLETION PRESERVE ENABLE

DO

CALL nuevaFactura();
