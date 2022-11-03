CREATE TABLE IF NOT EXISTS `data_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc` varchar(255) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lon` float(10,6) NOT NULL,
  `imgpath` varchar(255) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

INSERT INTO `data_location` (`id`, `desc`, `lat`, `lon`, `imgpath`) VALUES
(1, 'Ibukota Provinsi Aceh', 5.550176, 95.319260, './imgs/1.jpg'),
(2, 'Ibukota Kab.Aceh Jaya', 4.727890, 95.601372, './imgs/2.jpg'),
(3, 'Ibukota Abdya', 3.818570, 96.831841, './imgs/3.jpg'),
(4, 'Ibukota Kotamadya Langsa', 4.476020, 97.952446, './imgs/4.jpg'),
(5, 'Ibukota Kotamadya Sabang', 5.909284, 95.304741, './imgs/5.jpg');