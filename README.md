# lin-todo

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

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `darfsehen`
--
ALTER TABLE `darfsehen`
  ADD PRIMARY KEY (`dLID`,`dBID`),
  ADD KEY `dBID` (`dBID`);

--
-- Indizes für die Tabelle `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`IID`),
  ADD KEY `iLID` (`iLID`);

--
-- Indizes für die Tabelle `lists`
--
ALTER TABLE `lists`
  ADD PRIMARY KEY (`LID`),
  ADD KEY `lBID` (`lBID`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`BID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `items`
--
ALTER TABLE `items`
  MODIFY `IID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `lists`
--
ALTER TABLE `lists`
  MODIFY `LID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `BID` int NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `darfsehen`
--
ALTER TABLE `darfsehen`
  ADD CONSTRAINT `darfsehen_ibfk_1` FOREIGN KEY (`dBID`) REFERENCES `users` (`BID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `darfsehen_ibfk_2` FOREIGN KEY (`dLID`) REFERENCES `lists` (`LID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`iLID`) REFERENCES `lists` (`LID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `lists`
--
ALTER TABLE `lists`
  ADD CONSTRAINT `lists_ibfk_1` FOREIGN KEY (`lBID`) REFERENCES `users` (`BID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;