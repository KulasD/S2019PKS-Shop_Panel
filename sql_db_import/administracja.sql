-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 25 Lis 2019, 14:39
-- Wersja serwera: 10.4.6-MariaDB
-- Wersja PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `administracja`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dostawcy`
--

CREATE TABLE `dostawcy` (
  `id` int(11) NOT NULL,
  `nazwa` text COLLATE utf8_polish_ci NOT NULL,
  `nip` bigint(10) NOT NULL,
  `regon` int(9) NOT NULL,
  `adres` text COLLATE utf8_polish_ci NOT NULL,
  `kod_pocztowy` text COLLATE utf8_polish_ci NOT NULL,
  `miejscowosc` text COLLATE utf8_polish_ci NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL,
  `telefon` int(9) NOT NULL,
  `status` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `dostawcy`
--

INSERT INTO `dostawcy` (`id`, `nazwa`, `nip`, `regon`, `adres`, `kod_pocztowy`, `miejscowosc`, `email`, `telefon`, `status`) VALUES
(1, 'Dostarczam_Towary', 9876543210, 987654321, 'Tarnów', '11-111', 'Tarnów', 'dostarczamy@towary.org', 987654321, 'aktywny');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kadra`
--

CREATE TABLE `kadra` (
  `id` int(11) NOT NULL,
  `login` text COLLATE utf8_polish_ci NOT NULL,
  `haslo` text COLLATE utf8_polish_ci NOT NULL,
  `imie` text COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` text COLLATE utf8_polish_ci NOT NULL,
  `uprawnienia` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `kadra`
--

INSERT INTO `kadra` (`id`, `login`, `haslo`, `imie`, `nazwisko`, `uprawnienia`) VALUES
(1, 'admin', '$2y$10$ruAhiVCtWxX.ylVt5Ft3f.aYe.jxMxxtOfqzjB5fvK5l0xmLFewcS', 'Admin', 'Istrator', 'administrator'),
(2, 'kwachu', '$2y$10$ruAhiVCtWxX.ylVt5Ft3f.aYe.jxMxxtOfqzjB5fvK5l0xmLFewcS', 'Kwachu', 'Kwachu', 'administrator');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `dostawcy`
--
ALTER TABLE `dostawcy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `kadra`
--
ALTER TABLE `kadra`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `dostawcy`
--
ALTER TABLE `dostawcy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `kadra`
--
ALTER TABLE `kadra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
