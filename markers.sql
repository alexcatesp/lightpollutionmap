CREATE TABLE IF NOT EXISTS `data_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc` varchar(255) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lon` float(10,6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

INSERT INTO `data_location` (`id`, `desc`, `lat`, `lon`) VALUES
(1, 'Ibukota Provinsi Aceh', 5.550176, 95.319260),
(2, 'Ibukota Kab.Aceh Jaya', 4.727890, 95.601372),
(3, 'Ibukota Abdya', 3.818570, 96.831841),
(4, 'Ibukota Kotamadya Langsa', 4.476020, 97.952446),
(5, 'Ibukota Kotamadya Sabang', 5.909284, 95.304741);