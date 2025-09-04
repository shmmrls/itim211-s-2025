-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema db_music
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema db_music
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_music` DEFAULT CHARACTER SET utf8 ;
USE `db_music` ;

-- -----------------------------------------------------
-- Table `db_music`.`artists`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_music`.`artists` (
  `artist_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  `img_path` VARCHAR(45) NULL,
  PRIMARY KEY (`artist_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_music`.`albums`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_music`.`albums` (
  `album_id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NULL,
  `genre` VARCHAR(45) NULL,
  `date_released` DATE NULL,
  `artists_artist_id` INT NOT NULL,
  PRIMARY KEY (`album_id`),
  INDEX `fk_albums_artists1_idx` (`artists_artist_id` ASC),
  CONSTRAINT `fk_albums_artists1`
    FOREIGN KEY (`artists_artist_id`)
    REFERENCES `db_music`.`artists` (`artist_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_music`.`songs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_music`.`songs` (
  `song_id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NULL,
  `description` VARCHAR(45) NULL,
  `albums_album_id` INT NOT NULL,
  PRIMARY KEY (`song_id`),
  INDEX `fk_songs_albums1_idx` (`albums_album_id` ASC),
  CONSTRAINT `fk_songs_albums1`
    FOREIGN KEY (`albums_album_id`)
    REFERENCES `db_music`.`albums` (`album_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_music`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_music`.`users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(45) NULL,
  `password` VARCHAR(255) NULL,
  PRIMARY KEY (`user_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_music`.`listeners`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_music`.`listeners` (
  `listener_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `address` VARCHAR(45) NULL,
  `img_path` VARCHAR(45) NULL,
  `users_user_id` INT NOT NULL,
  PRIMARY KEY (`listener_id`),
  INDEX `fk_listeners_users_idx` (`users_user_id` ASC),
  CONSTRAINT `fk_listeners_users`
    FOREIGN KEY (`users_user_id`)
    REFERENCES `db_music`.`users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_music`.`albums_listeners`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_music`.`albums_listeners` (
  `albums_album_id` INT NOT NULL,
  `listeners_listener_id` INT NOT NULL,
  `reviews` INT NULL,
  `comment` VARCHAR(45) NULL,
  PRIMARY KEY (`albums_album_id`, `listeners_listener_id`),
  INDEX `fk_albums_has_listeners_listeners1_idx` (`listeners_listener_id` ASC),
  INDEX `fk_albums_has_listeners_albums1_idx` (`albums_album_id` ASC),
  CONSTRAINT `fk_albums_has_listeners_albums1`
    FOREIGN KEY (`albums_album_id`)
    REFERENCES `db_music`.`albums` (`album_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_albums_has_listeners_listeners1`
    FOREIGN KEY (`listeners_listener_id`)
    REFERENCES `db_music`.`listeners` (`listener_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
