-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- ����: 127.0.0.1:3306
-- ����� ��������: ��� 25 2016 �., 11:27
-- ������ �������: 5.5.41-log
-- ������ PHP: 5.4.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- ���� ������: `test_task`
--

-- --------------------------------------------------------

--
-- ��������� ������� `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) CHARACTER SET cp1251 NOT NULL DEFAULT '0',
  `password` varchar(50) CHARACTER SET cp1251 NOT NULL DEFAULT '0',
  `salt` varchar(50) NOT NULL DEFAULT '0',
  `username` varchar(50) CHARACTER SET cp1251 DEFAULT NULL,
  `photo` varchar(50) DEFAULT NULL,
  `date_birth` date NOT NULL DEFAULT '0000-00-00',
  `gender` tinyint(1) DEFAULT NULL,
  `about` text CHARACTER SET cp1251,
  `phone` varchar(15) CHARACTER SET cp1251 DEFAULT NULL,
  `date_reg` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `������ 2` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;