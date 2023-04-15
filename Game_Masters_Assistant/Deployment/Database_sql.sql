-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2023 at 05:23 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fyp`
--

-- --------------------------------------------------------

--
-- Table structure for table `campaign`
--

CREATE TABLE `campaign` (
  `CAMPAIGN_ID` int(11) NOT NULL,
  `CAMPAIGN_NAME` text NOT NULL,
  `GAME_MASTER_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `campaign`
--

INSERT INTO `campaign` (`CAMPAIGN_ID`, `CAMPAIGN_NAME`, `GAME_MASTER_ID`) VALUES
(1, 'DragonSpire Mines', 1),
(24, 'The Salt Lake', 10),
(25, 'Misadventures of River Run', 10),
(26, 'The Contest', 10),
(27, 'The Last Dance', 10),
(28, 'Investigation', 10);

-- --------------------------------------------------------

--
-- Table structure for table `campaign_characters`
--

CREATE TABLE `campaign_characters` (
  `CHARACTER_ID` int(11) NOT NULL,
  `CHARACTER_NAME` varchar(48) NOT NULL,
  `CHARACTER_STATS` longtext NOT NULL DEFAULT '1',
  `CAMPAIGN_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `PICTURE` longtext DEFAULT NULL,
  `CHARACTER_NOTES` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `campaign_characters`
--

INSERT INTO `campaign_characters` (`CHARACTER_ID`, `CHARACTER_NAME`, `CHARACTER_STATS`, `CAMPAIGN_ID`, `USER_ID`, `PICTURE`, `CHARACTER_NOTES`) VALUES
(1, 'Cassion Dracos', 'level:1,Courage:2,Strength:3, int:5', 1, 1, '../Resources/uploads/1/player_images/1_salamder.jpg', 'Ex-military wanted more from life so left the army to become an adventure'),
(9, 'Ahab', ' level:1', 1, 3, '../Resources/uploads/1/player_images/10_1_20230208_104320.jpg', 'Captain of of a fishing ship'),
(15, 'Bilbo', 'Level:1,', 1, 10, NULL, '111 years old');

-- --------------------------------------------------------

--
-- Table structure for table `invites`
--

CREATE TABLE `invites` (
  `INVITE_ID` int(11) NOT NULL,
  `PLAYER_ID` int(11) NOT NULL,
  `CAMPAIGN_ID` int(11) NOT NULL,
  `RESPONSE` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invites`
--

INSERT INTO `invites` (`INVITE_ID`, `PLAYER_ID`, `CAMPAIGN_ID`, `RESPONSE`) VALUES
(44, 1, 1, 1),
(45, 3, 1, 1),
(46, 10, 1, 1),
(47, 10, 24, 1),
(48, 10, 25, 1),
(49, 10, 26, 1),
(50, 10, 27, 1),
(51, 10, 28, 1),
(52, 1, 24, 1),
(53, 1, 25, 1),
(54, 1, 26, NULL),
(55, 1, 27, NULL),
(56, 1, 28, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `ITEM_ID` int(11) NOT NULL,
  `ITEM_NAME` text NOT NULL,
  `ITEM_DESCRIPTION` longtext NOT NULL,
  `CAMPAIGN_ID` int(11) NOT NULL,
  `ACTIVE` tinyint(1) NOT NULL,
  `HELD_BY` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`ITEM_ID`, `ITEM_NAME`, `ITEM_DESCRIPTION`, `CAMPAIGN_ID`, `ACTIVE`, `HELD_BY`) VALUES
(2, 'Greataxe', '1d6 bludgeoning, 10lb, two handed', 1, 1, ''),
(8, 'Ring of invisibility ', 'Turns the user invisible', 1, 1, ',10,'),
(9, 'rope', '50 feet long', 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `MESSAGE_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `CAMPAIGN_ID` int(11) NOT NULL,
  `MESSAGE` text NOT NULL,
  `DESTINATION` text NOT NULL,
  `DATE_TIME` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`MESSAGE_ID`, `USER_ID`, `CAMPAIGN_ID`, `MESSAGE`, `DESTINATION`, `DATE_TIME`) VALUES
(60, 3, 1, 'example_user:I enter the room', ',1,3,10,', '2023-04-14'),
(61, 1, 1, 'example_gm:make a wisdom save', ',3,1,10,', '2023-04-14'),
(62, 3, 1, 'example_user:Dice:18', ',1,3,10,', '2023-04-14'),
(64, 1, 1, 'example_gm:example_user: you are effected by the trap ', ',1,3,', '2023-04-14'),
(65, 10, 1, 'example_user_2:I enter the room', ',,1,3,10,10,,1,', '2023-04-14'),
(66, 1, 1, 'Announcement:The room starts to shake', ',,1,3,10,1,', '2023-04-14');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `NOTE_ID` int(11) NOT NULL,
  `CAMPAIGN_ID` int(11) NOT NULL,
  `OWNER_ID` int(11) NOT NULL,
  `CHAPTER` mediumtext NOT NULL,
  `NOTES` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`NOTE_ID`, `CAMPAIGN_ID`, `OWNER_ID`, `CHAPTER`, `NOTES`) VALUES
(1, 1, 1, 'chapter 1', 'I met a traveller from an antique land,\r\nWho said—“Two vast and trunkless legs of stone\r\nStand in the desert. . . . Near them, on the sand,\r\nHalf sunk a shattered visage lies, whose frown,\r\nAnd wrinkled lip, and sneer of cold command,\r\nTell that its sculptor well those passions read\r\nWhich yet survive, stamped on these lifeless things,\r\nThe hand that mocked them, and the heart that fed;\r\n-PERCY BYSSHE SHELLEY'),
(2, 1, 1, 'chapter 2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent condimentum eros mauris, at porta turpis sodales eget. Sed molestie ligula eu mi ultricies, at tempor nunc molestie. Nam posuere nisi non hendrerit mattis. Nullam maximus nunc in convallis pulvinar. Fusce purus turpis, semper nec lorem at, elementum cursus erat. Aliquam vitae orci a justo commodo dignissim non et ipsum. Vivamus fringilla ex ligula, vitae fringilla turpis maximus eu. Nulla facilisi. Fusce mollis egestas arcu nec sollicitudin. Quisque nec metus ligula. Ut ultrices mauris eget ipsum consectetur cons'),
(3, 1, 1, 'chapter3', 'ulla pellentesque mattis felis vitae tincidunt. Morbi sapien sem, rhoncus at libero non, ultricies pretium nisl. Pellentesque mi massa, lobortis a urna nec, faucibus faucibus turpis. Proin finibus leo magna, ac faucibus sem hendrerit non. Maecenas mollis, ex id dictum molestie, tellus tellus tincidunt ur'),
(4, 1, 1, 'Location: River Run', 'Sed eleifend mi vel interdum faucibus. Suspendisse lacinia, sapien ac ornare placerat, turpis lectus elementum purus, in aliquet est nunc ut metus. Cras non ex tortor. '),
(13, 1, 10, 'Concerning hobbits', '“In a hole in the ground there lived a hobbit. Not a nasty, dirty, wet hole, filled with the ends of worms and an oozy smell, nor yet a dry, bare, sandy hole with nothing in it to sit down on or to eat: it was a hobbit-hole, and that means comfort.”\r\n\r\n― J.R.R. Tolkien, The Hobbit');

-- --------------------------------------------------------

--
-- Table structure for table `npc_characters`
--

CREATE TABLE `npc_characters` (
  `NPC_ID` int(11) NOT NULL,
  `NPC_NAME` text NOT NULL,
  `NPC_STATS` text NOT NULL,
  `NOTES` longtext NOT NULL,
  `CAMPAIGN_ID` int(11) NOT NULL,
  `ACTIVE` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `npc_characters`
--

INSERT INTO `npc_characters` (`NPC_ID`, `NPC_NAME`, `NPC_STATS`, `NOTES`, `CAMPAIGN_ID`, `ACTIVE`) VALUES
(1, 'Runara', 'str:+7,Dex:0,CON:+6,INt:+3,Wis:+2,CHa:+4', 'Leader of dragon rest, guides the residents of the cloister in their study ', 1, 1),
(8, 'Samwise', 'Level:1,', '', 1, 1),
(9, 'Ishmael', 'Level:1,', '', 1, 1),
(10, 'Pippin', 'Level:1,', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `npc_monster`
--

CREATE TABLE `npc_monster` (
  `MONSTER_ID` int(11) NOT NULL,
  `MONSTER_NAME` text NOT NULL,
  `MONSTER_STATS` longtext NOT NULL,
  `NOTES` longtext NOT NULL,
  `CAMPAIGN_ID` int(11) NOT NULL,
  `ACTIVE` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `npc_monster`
--

INSERT INTO `npc_monster` (`MONSTER_ID`, `MONSTER_NAME`, `MONSTER_STATS`, `NOTES`, `CAMPAIGN_ID`, `ACTIVE`) VALUES
(2, 'Ogre ZOMBIE', 'Str:+4,Dex:-2,Con:+4,Int:-4,Wisdom:-2,Cha:-3,AC:8,Speed:30ft', 'immunity: poison\r\nsenses: darkvision\r\nUndead Fortitude: on 0 hp make con save \r\n', 1, 0),
(3, 'Nightmare', 'Str:+4,DEX:+2,Con:+3,Int:0,Wis:+1,Char:+2', 'confer fire resistance, illumination, Ethereal Stride. the nightmare and up to three willing creatures within 5 feet magically enter the ethereal plane from material plane ', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `shared_images`
--

CREATE TABLE `shared_images` (
  `IMAGE_ID` int(11) NOT NULL,
  `PATH` mediumtext NOT NULL,
  `ACTIVE` tinyint(1) NOT NULL,
  `CAMPAIGN_ID` int(11) NOT NULL,
  `BACK_GROUND` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shared_images`
--

INSERT INTO `shared_images` (`IMAGE_ID`, `PATH`, `ACTIVE`, `CAMPAIGN_ID`, `BACK_GROUND`) VALUES
(24, '../Resources/uploads/1/Ocean-sea-water-tile-texture-map-assets-night.jpg', 0, 1, 1),
(25, '../Resources/uploads/1/chessboard.jpg', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `status_effect`
--

CREATE TABLE `status_effect` (
  `EFFECT_ID` int(11) NOT NULL,
  `EFFECT_NAME` mediumtext NOT NULL,
  `NOTES` longtext DEFAULT NULL,
  `ACTIVE` tinyint(1) DEFAULT NULL,
  `CAMPAIGN_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `USER_ID` int(11) NOT NULL,
  `USER_NAME` text NOT NULL,
  `USER_PASSWORD` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`USER_ID`, `USER_NAME`, `USER_PASSWORD`) VALUES
(1, 'example_gm', '$2y$10$gw1lPSfBhjZbIl1ZQeTEcOwbYGy9T37s2IBAx2htgEEwKqY8xb/Ri'),
(3, 'example_user', '$2y$10$cVK5KlNNbvcAQL1ySJyEMOaOEWDGCg5CnV1ByHD8i.CpyQMD/MvJy'),
(10, 'example_user_2', '$2y$10$SheB0tiOdFl6pyq0lGGlMOA8Ma4Rrl/tXX31PRcDKfsejBvPtPVaW');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `campaign`
--
ALTER TABLE `campaign`
  ADD PRIMARY KEY (`CAMPAIGN_ID`);

--
-- Indexes for table `campaign_characters`
--
ALTER TABLE `campaign_characters`
  ADD PRIMARY KEY (`CHARACTER_ID`);

--
-- Indexes for table `invites`
--
ALTER TABLE `invites`
  ADD PRIMARY KEY (`INVITE_ID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`ITEM_ID`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`MESSAGE_ID`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`NOTE_ID`);

--
-- Indexes for table `npc_characters`
--
ALTER TABLE `npc_characters`
  ADD PRIMARY KEY (`NPC_ID`);

--
-- Indexes for table `npc_monster`
--
ALTER TABLE `npc_monster`
  ADD PRIMARY KEY (`MONSTER_ID`);

--
-- Indexes for table `shared_images`
--
ALTER TABLE `shared_images`
  ADD PRIMARY KEY (`IMAGE_ID`);

--
-- Indexes for table `status_effect`
--
ALTER TABLE `status_effect`
  ADD PRIMARY KEY (`EFFECT_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`USER_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `campaign`
--
ALTER TABLE `campaign`
  MODIFY `CAMPAIGN_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `campaign_characters`
--
ALTER TABLE `campaign_characters`
  MODIFY `CHARACTER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `invites`
--
ALTER TABLE `invites`
  MODIFY `INVITE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `ITEM_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `MESSAGE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `NOTE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `npc_characters`
--
ALTER TABLE `npc_characters`
  MODIFY `NPC_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `npc_monster`
--
ALTER TABLE `npc_monster`
  MODIFY `MONSTER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `shared_images`
--
ALTER TABLE `shared_images`
  MODIFY `IMAGE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `status_effect`
--
ALTER TABLE `status_effect`
  MODIFY `EFFECT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
