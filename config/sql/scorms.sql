-- phpMyAdmin SQL Dump
-- version 2.10.0.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Sep 21, 2007 at 11:23 AM
-- Server version: 5.0.37
-- PHP Version: 5.2.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `osmosis`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `scorms`
-- 

CREATE TABLE `scorms` (
  `id` int(11) unsigned NOT NULL auto_increment COMMENT 'primary key',
  `course_id` int(11) NOT NULL COMMENT 'foreign key to course',
  `name` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT 'name for scorm asset',
  `file_name` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT 'file name of scorm package',
  `description` text collate utf8_unicode_ci NOT NULL COMMENT 'description of scorm asset',
  `version` varchar(9) collate utf8_unicode_ci NOT NULL COMMENT 'scorm version',
  `created` timestamp NOT NULL default '0000-00-00 00:00:00' COMMENT 'created time',
  `modified` timestamp NOT NULL default '0000-00-00 00:00:00' COMMENT 'modified time',
  `hash` varchar(35) collate utf8_unicode_ci NOT NULL COMMENT 'hash sum of file reference',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Represents a scorm asset in a course' AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `scorms`
-- 
