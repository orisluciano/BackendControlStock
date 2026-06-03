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

  CREATE TABLE `controlstockdb`.`stock` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fechaCreacion` DATETIME NULL,
  `fechaMod` DATETIME NULL,
  `borrado` TINYINT NULL,
  `actual` DOUBLE(10,2) NULL,
  `minimo` DOUBLE(10,2) NULL,
  `maximo` DOUBLE(10,2) NULL,
  `productoId` INT NULL,
  `tipoStockId` INT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `controlstockdb`.`tipostock` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fechaCreacion` DATETIME NULL,
  `fechaMod` DATETIME NULL,
  `borrado` TINYINT NULL,
  `descripcion` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));

  CREATE TABLE `controlstockdb`.`movimientostock` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fechaCreacion` DATETIME NULL,
  `fechaMod` DATETIME NULL,
  `borrado` TINYINT NULL,
  `stockId` INT NOT NULL,
  `cantidad` DOUBLE(10,2) NULL,
  `tipo` ENUM("Entrada", "Salida"),
  `motivoMovId` INT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `controlstockdb`.`motivomovimiento` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fechaCreacion` DATETIME NOT NULL,
  `fechaMod` DATETIME NOT NULL,
  `borrado` TINYINT NOT NULL,
  `tipo` ENUM("Entrada", "Salida") NOT NULL,
  `descripcion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `controlstockdb`.`tipoproducto` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fechaCreacion` DATETIME NOT NULL,
  `fechaMod` DATETIME NOT NULL,
  `borrado` TINYINT NOT NULL,
  `descripcion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`));



  