-- Procedure genera missatges
DELIMITER // 
CREATE PROCEDURE procGeneraMissatges(IN IdContingut INT, IN nomCat VARCHAR(20))
BEGIN
DECLARE locusername VARCHAR(15);
DECLARE hihaerror BOOLEAN;
DECLARE usuarisMissatge CURSOR FOR  SELECT persona.username FROM (categoriafavorits JOIN contracte ON contracte.IdContracte=categoriafavorits.IdContracte AND categoriafavorits.nomCat=nomCat) JOIN persona ON contracte.username=persona.username; # Seleccionam els contractes que tenen la categoria de la pel·lícula inserida com a favorita i després lusuari al que pertany el contracte
DECLARE CONTINUE HANDLER FOR NOT FOUND SET hihaerror=true;
  
  OPEN usuarisMissatge;
  etiq: LOOP
	FETCH usuarisMissatge INTO locusername;
    IF hihaerror THEN
    	LEAVE etiq;
    END IF;
    
	INSERT INTO missatge(data,assumpte,descripcio, estatMissatge, username, IdContingut) VALUES (CURRENT_DATE,"Nueva película en el catálogo", "Hola! Estamos aumentando nuestro catálogo cada dia. Preprara las palomitas y disfruta de la nueva película: ", false, locusername, IdContingut);

	END LOOP;
END;

-- Trigger genera missatges
DELIMITER //
CREATE TRIGGER GeneraMissatges
AFTER INSERT ON contingut
FOR EACH ROW
BEGIN
	call procGeneraMissatges(NEW.IdContingut, NEW.nomCat);
END;