CREATE TABLE `controlstockdb`.`productos` (`id` INT NOT NULL AUTO_INCREMENT , `fechaCreacion` DATETIME NOT NULL , `fechaMod` DATETIME NOT NULL , `borrado` BOOLEAN NOT NULL , `nombre` VARCHAR(45) NOT NULL , `descripcion` VARCHAR(45) NOT NULL , `codSKU` VARCHAR(45) NOT NULL , `tipoProductoId` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `controlstockdb`.`precios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fechaCreacion` DATETIME NULL,
  `fechaMod` DATETIME NULL,
  `borrado` TINYINT NULL,
  `costo` DECIMAL(10,2) NULL,
  `venta` DECIMAL(10,2) NULL,
  `productoId` INT NULL,
  PRIMARY KEY (`id`));