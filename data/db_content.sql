INSERT INTO `player` (
  `name`,
  `born`,
  `transfermarkt`,
  `classic`,
  `enabled`
) VALUES (
  'david beckham',
  1975,
  'http://www.transfermarkt.com/david-beckham/profil/spieler/3139',
  TRUE,
  TRUE
);

INSERT INTO `team` (
  `name`,
  `enabled`
) VALUES (
  'england',
  TRUE
);

INSERT INTO `player__team` (
  `player_id`,
  `team_id`
) VALUES (
  1,
  1
);


