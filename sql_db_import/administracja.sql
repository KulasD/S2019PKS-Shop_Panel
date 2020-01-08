-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 08 Sty 2020, 02:51
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
(1, 'Dostarczam_Towary', 9876543210, 987654321, 'Tarnów', '11-111', 'Tarnów', 'dostarczamy@towary.org', 987654321, 'aktywny'),
(3, 'Dostarczam_Towary', 11, 112, '2asdasdasd asd asd', '22-222', '2a sd asd as d', 'kwachu9999@interia.pl', 221111111, 'nieaktywny'),
(4, 'Zmienilismy Nazwe', 11, 112, '2asdasdasd asd asd', '22-222', '2a sd asd as d', 'kwachu9999@interia.pl', 221111111, 'aktywny');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dostawy`
--

CREATE TABLE `dostawy` (
  `id_dostawy` int(11) NOT NULL,
  `id_dostawcy` int(11) NOT NULL,
  `data` text COLLATE utf8_polish_ci NOT NULL,
  `status` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `dostawy`
--

INSERT INTO `dostawy` (`id_dostawy`, `id_dostawcy`, `data`, `status`) VALUES
(1, 1, '2019-10-28 21:13:13', 'oczekiwanie na towary'),
(2, 4, '2020-01-07 22:45:44', 'oczekiwanie na towary'),
(3, 4, '2020-01-07 22:50:05', 'oczekiwanie na towary'),
(4, 4, '2020-01-07 22:53:43', 'towary dostarczone'),
(5, 1, '2020-01-08 01:05:03', 'dostawa anulowana'),
(6, 1, '2020-01-08 02:13:40', 'towary dostarczone'),
(7, 4, '2020-01-08 02:16:32', 'towary dostarczone');

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

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty_do_dostawy`
--

CREATE TABLE `produkty_do_dostawy` (
  `id_pdd` int(11) NOT NULL,
  `ilosc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty_z_dostawy`
--

CREATE TABLE `produkty_z_dostawy` (
  `id` int(11) NOT NULL,
  `id_dostawy` int(11) NOT NULL,
  `id_pzd` int(11) NOT NULL,
  `ilosc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `produkty_z_dostawy`
--

INSERT INTO `produkty_z_dostawy` (`id`, `id_dostawy`, `id_pzd`, `ilosc`) VALUES
(6, 2, 7, 12),
(7, 2, 14, 13),
(8, 2, 18, 14),
(9, 3, 21, 1),
(10, 3, 25, 2),
(11, 3, 38, 3),
(12, 4, 1, 100),
(13, 5, 7, 5),
(14, 5, 14, 5),
(15, 6, 14, 14),
(16, 7, 14, 7);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `dostawcy`
--
ALTER TABLE `dostawcy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `dostawy`
--
ALTER TABLE `dostawy`
  ADD PRIMARY KEY (`id_dostawy`);

--
-- Indeksy dla tabeli `kadra`
--
ALTER TABLE `kadra`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `produkty_do_dostawy`
--
ALTER TABLE `produkty_do_dostawy`
  ADD PRIMARY KEY (`id_pdd`);

--
-- Indeksy dla tabeli `produkty_z_dostawy`
--
ALTER TABLE `produkty_z_dostawy`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `dostawcy`
--
ALTER TABLE `dostawcy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `dostawy`
--
ALTER TABLE `dostawy`
  MODIFY `id_dostawy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `kadra`
--
ALTER TABLE `kadra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `produkty_z_dostawy`
--
ALTER TABLE `produkty_z_dostawy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
