# lin-todo

https://hmbldtw.spdns.org/
=======

-- Tabellenstruktur für Tabelle `darfsehen`
--

CREATE TABLE `darfsehen` (
  `dLID` int NOT NULL,
  `dBID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `items`
--

CREATE TABLE `items` (
  `IID` int NOT NULL,
  `content` varchar(255) NOT NULL,
  `due` datetime NOT NULL,
  `is_done` tinyint(1) NOT NULL,
  `iLID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lists`
--

CREATE TABLE `lists` (
  `LID` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `lBID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `BID` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

