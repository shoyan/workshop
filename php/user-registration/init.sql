-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Apr 26, 2020 at 07:13 AM
-- Server version: 5.7.26
-- PHP Version: 7.3.8
SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET
  time_zone = "+00:00";
--
  -- Database: `workshop`
  --
  -- --------------------------------------------------------
  --
  -- Table structure for table `users`
  --
  CREATE TABLE `users` (
    `id` int(11) NOT NULL,
    `user_name` varchar(255) NOT NULL,
    `email` varchar(400) NOT NULL,
    `password` varchar(255) NOT NULL,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8;
--
  -- Indexes for dumped tables
  --
  --
  -- Indexes for table `users`
  --
ALTER TABLE `users`
ADD
  PRIMARY KEY (`id`);
--
  -- AUTO_INCREMENT for dumped tables
  --
  --
  -- AUTO_INCREMENT for table `users`
  --
ALTER TABLE `users`
MODIFY
  `id` int(11) NOT NULL AUTO_INCREMENT;
