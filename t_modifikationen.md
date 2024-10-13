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
