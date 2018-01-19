-- phpMyAdmin SQL Dump
-- version 4.4.15.8
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 18, 2018 at 12:59 PM
-- Server version: 5.6.31-0ubuntu0.14.04.2
-- PHP Version: 5.6.23-1+deprecated+dontuse+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rbam-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cxs_aliases`
--

CREATE TABLE IF NOT EXISTS `cxs_aliases` (
  `ALIAS_ID` bigint(20) NOT NULL,
  `ALIAS_NAME` varchar(50) NOT NULL DEFAULT '',
  `PERIOD_NAME` varchar(50) NOT NULL DEFAULT '',
  `PROJECT_NUMBER` varchar(50) NOT NULL DEFAULT '',
  `TASK_NUMBER` varchar(50) NOT NULL DEFAULT '',
  `EXPENDITURE_TYPE` varchar(50) NOT NULL DEFAULT '',
  `DESCRIPTION` varchar(240) NOT NULL DEFAULT '',
  `EMPLOYEE_NUMBER` varchar(30) NOT NULL DEFAULT '',
  `XXTPAA_COMMENT` varchar(240) NOT NULL DEFAULT '',
  `LAST_UPDATE_LOGIN` bigint(20) NOT NULL DEFAULT '0',
  `ORG_ID` bigint(20) NOT NULL DEFAULT '0',
  `ALIAS_STATUS` varchar(50) NOT NULL DEFAULT '',
  `RESOURCE_TYPE` varchar(50) NOT NULL DEFAULT '',
  `CATEGORY` varchar(240) NOT NULL DEFAULT '',
  `SUB_CATEGORY` varchar(240) NOT NULL DEFAULT '',
  `ETRACKER_CCD_NO` varchar(50) NOT NULL DEFAULT '',
  `COPY_ALLOWED` varchar(1) NOT NULL DEFAULT '',
  `ACTIVE_FLAG` varchar(1) NOT NULL DEFAULT '',
  `AUTOPOPULATE` varchar(1) NOT NULL DEFAULT '',
  `WBS_ID` bigint(20) NOT NULL DEFAULT '0',
  `CREATED_BY` bigint(20) NOT NULL,
  `CREATION_DATE` date NOT NULL,
  `LAST_UPDATED_BY` bigint(20) NOT NULL,
  `LAST_UPDATE_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ALIAS_TYPE` varchar(350) NOT NULL DEFAULT '',
  `ALIAS_CLASS` varchar(50) NOT NULL DEFAULT '',
  `ADDINUSE_FLAG` varchar(1) NOT NULL DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cxs_aliases`
--

INSERT INTO `cxs_aliases` (`ALIAS_ID`, `ALIAS_NAME`, `PERIOD_NAME`, `PROJECT_NUMBER`, `TASK_NUMBER`, `EXPENDITURE_TYPE`, `DESCRIPTION`, `EMPLOYEE_NUMBER`, `XXTPAA_COMMENT`, `LAST_UPDATE_LOGIN`, `ORG_ID`, `ALIAS_STATUS`, `RESOURCE_TYPE`, `CATEGORY`, `SUB_CATEGORY`, `ETRACKER_CCD_NO`, `COPY_ALLOWED`, `ACTIVE_FLAG`, `AUTOPOPULATE`, `WBS_ID`, `CREATED_BY`, `CREATION_DATE`, `LAST_UPDATED_BY`, `LAST_UPDATE_DATE`, `ALIAS_TYPE`, `ALIAS_CLASS`, `ADDINUSE_FLAG`) VALUES
(1, 'ABC1', '', '', '', '', 'aa123', '', '', 0, 0, '', '', '', '', '', 'Y', 'Y', 'Y', 1, 2, '2017-11-25', 1, '2017-11-27 06:53:23', 'RES-Resource Specific Alias', '', 'Y'),
(2, 'ALIAS2', '', '', '', '', 'description2', '', '', 0, 0, '', '', '', '', '', 'Y', 'N', 'N', 4, 1, '2017-11-25', 1, '2017-11-25 09:28:44', 'RES-Resource Specific Alias', '', 'N'),
(3, 'ALIAS4', '', '', '', '', 'a', '', '', 0, 0, '', '', '', '', '', 'N', 'N', 'N', 1, 1, '2017-11-25', 1, '2017-11-25 08:32:47', 'RES-Resource Specific Alias', '', 'N'),
(4, 'ALIAS1', '', '', '', '', 'test description 3', '', '', 0, 0, '', '', '', '', '', 'Y', 'Y', 'N', 6, 2, '2017-11-27', 1, '2017-11-27 06:55:35', 'RES-Resource Specific Alias', '', 'Y'),
(5, 'ALIAS3', '', '', '', '', 'test description 3', '', '', 0, 0, '', '', '', '', '', 'Y', 'Y', 'N', 6, 1, '2017-11-27', 1, '2017-11-27 06:54:02', 'RES-Resource Specific Alias', '', 'Y'),
(9, 'ALIAS1', '', '', '', '', 'test description 3', '', '', 0, 0, '', '', '', '', '', 'Y', 'Y', 'N', 6, 1, '2017-11-27', 1, '2017-11-27 07:19:35', 'RES-Resource Specific Alias', '', 'Y'),
(8, 'ABC1', '', '', '', '', 'aa123', '', '', 0, 0, '', '', '', '', '', 'Y', 'Y', 'Y', 1, 1, '2017-11-27', 1, '2017-11-27 07:19:35', 'RES-Resource Specific Alias', '', 'Y'),
(10, 'ABC1', '', '', '', '', 'aa123', '', '', 0, 0, '', '', '', '', '', 'Y', 'Y', 'Y', 1, 1, '2017-11-27', 1, '2017-11-27 07:21:20', 'RES-Resource Specific Alias', '', 'Y'),
(11, 'ABC1', '', '', '', '', 'aa123', '', '', 0, 0, '', '', '', '', '', 'Y', 'Y', 'Y', 1, 1, '2017-11-27', 1, '2017-11-27 07:21:20', 'RES-Resource Specific Alias', '', 'Y'),
(12, 'ALIAS1', '', '', '', '', 'test description 3', '', '', 0, 0, '', '', '', '', '', 'Y', 'Y', 'N', 6, 1, '2017-11-27', 1, '2017-11-27 07:21:20', 'RES-Resource Specific Alias', '', 'Y'),
(13, 'ALIAS3A', '', '', '', '', 'a', '', '', 0, 0, '', '', '', '', '', 'Y', 'N', 'Y', 1, 1, '2017-11-27', 1, '2017-11-27 07:22:32', 'RES-Resource Specific Alias', '', 'N'),
(14, 'ALIAS2', '', '', '', '', 'description2', '', '', 0, 0, '', '', '', '', '', 'Y', 'N', 'N', 4, 1, '2017-11-27', 1, '2017-11-27 07:24:55', 'RES-Resource Specific Alias', '', 'N'),
(15, 'ALIAS2', '', '', '', '', 'description2', '', '', 0, 0, '', '', '', '', '', 'Y', 'N', 'N', 4, 1, '2017-11-27', 1, '2017-11-27 07:25:43', 'RES-Resource Specific Alias', '', 'N'),
(16, 'ABC1', '', '', '', '', 'aa123', '', '', 0, 0, '', '', '', '', '', 'Y', 'Y', 'N', 1, 1, '2017-11-27', 1, '2017-11-27 07:39:42', 'RES-Resource Specific Alias', '', 'N'),
(17, 'ALIAS4', '', '', '', '', 'a', '', '', 0, 0, '', '', '', '', '', 'N', 'N', 'N', 1, 1, '2017-11-27', 1, '2017-11-27 07:32:18', 'RES-Resource Specific Alias', '', 'N'),
(18, 'ALIAS4', '', '', '', '', 'a', '', '', 0, 0, '', '', '', '', '', 'N', 'N', 'N', 1, 1, '2017-11-27', 1, '2017-11-27 07:33:03', 'RES-Resource Specific Alias', '', 'N'),
(19, 'ABC1', '', '', '', '', 'aa123', '', '', 0, 0, '', '', '', '', '', 'N', 'Y', 'N', 1, 1, '2017-11-27', 1, '2017-11-27 07:37:45', 'RES-Resource Specific Alias', '', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `cxs_am_approval_mgmt`
--

CREATE TABLE IF NOT EXISTS `cxs_am_approval_mgmt` (
  `USER_ID` bigint(20) NOT NULL,
  `CREATED_BY` bigint(20) NOT NULL,
  `CREATION_DATE` date NOT NULL,
  `LAST_UPDATED_BY` bigint(20) NOT NULL,
  `LAST_UPDATE_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `APPROVER_TYPE_FLAG` varchar(1) NOT NULL,
  `APPROVE_DIRECT_REPORT` varchar(1) NOT NULL,
  `ALLOW_UPDATE_APPROVE_TS` varchar(1) NOT NULL,
  `ALLOW_ON_THE_FLY` varchar(1) NOT NULL,
  `PROJECT_BASED_APPROVAL` varchar(1) NOT NULL,
  `REFERENCE_APPROVER_ID` bigint(20) NOT NULL,
  `APPROVER_TYPE` varchar(40) NOT NULL,
  `APPROVER_ORDER` bigint(20) NOT NULL,
  `ROWNO` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cxs_am_app_admin`
--

CREATE TABLE IF NOT EXISTS `cxs_am_app_admin` (
  `APP_ADM_ID` int(11) NOT NULL,
  `USER_ID` bigint(20) NOT NULL,
  `CREATED_BY` bigint(20) NOT NULL,
  `CREATION_DATE` date NOT NULL,
  `LAST_UPDATED_BY` bigint(20) NOT NULL,
  `LAST_UPDATE_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `APPLICATION_ID` bigint(20) NOT NULL,
  `START_DATE_ACTIVE` date NOT NULL,
  `END_DATE_ACTIVE` date NOT NULL,
  `ROWNO` bigint(20) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cxs_am_app_admin`
--

INSERT INTO `cxs_am_app_admin` (`APP_ADM_ID`, `USER_ID`, `CREATED_BY`, `CREATION_DATE`, `LAST_UPDATED_BY`, `LAST_UPDATE_DATE`, `APPLICATION_ID`, `START_DATE_ACTIVE`, `END_DATE_ACTIVE`, `ROWNO`) VALUES
(1, 2, 20, '2018-01-05', 0, '2018-01-05 14:27:55', 1, '2018-01-09', '2018-01-25', 0),
(2, 18, 20, '2018-01-05', 20, '2018-01-08 07:59:52', 2, '2018-01-10', '2018-01-24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cxs_am_personal_alias`
--

CREATE TABLE IF NOT EXISTS `cxs_am_personal_alias` (
  `USER_ID` bigint(20) DEFAULT NULL,
  `CREATED_BY` bigint(20) DEFAULT NULL,
  `CREATION_DATE` date DEFAULT NULL,
  `LAST_UPDATED_BY` bigint(20) DEFAULT NULL,
  `LAST_UPDATE_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ALIAS_ID` bigint(20) DEFAULT NULL,
  `ALIAS_NAME` varchar(40) DEFAULT NULL,
  `DESCRIPTION` varchar(240) DEFAULT NULL,
  `DEPARTMENT` varchar(40) DEFAULT NULL,
  `WBS_COMBINATION_ID` bigint(20) DEFAULT NULL,
  `ACTIVE_FLAG` varchar(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cxs_am_personal_alias`
--

INSERT INTO `cxs_am_personal_alias` (`USER_ID`, `CREATED_BY`, `CREATION_DATE`, `LAST_UPDATED_BY`, `LAST_UPDATE_DATE`, `ALIAS_ID`, `ALIAS_NAME`, `DESCRIPTION`, `DEPARTMENT`, `WBS_COMBINATION_ID`, `ACTIVE_FLAG`) VALUES
(1, 1, '2017-09-07', 1, '2017-09-07 05:07:39', 1, 'abc alias', 'alias description', 'xyz dept', 2, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `cxs_am_roles`
--

CREATE TABLE IF NOT EXISTS `cxs_am_roles` (
  `ROLE_ID` int(11) NOT NULL,
  `ROLE_NAME` varchar(40) NOT NULL,
  `DESCRIPTION` varchar(240) NOT NULL,
  `CREATED_BY` int(11) NOT NULL,
  `LAST_UPDATED_BY` int(11) NOT NULL,
  `CREATION_DATE` date NOT NULL,
  `LAST_UPDATE_DATE` date NOT NULL,
  `CREATE_NEW_USER` varchar(1) NOT NULL,
  `VIEW_ONLY` varchar(1) NOT NULL,
  `UPDATE_ONLY` varchar(1) NOT NULL,
  `VIEW_SUBSCRIBERS` varchar(1) NOT NULL,
  `SUBMIT_CUSTOM` varchar(1) NOT NULL,
  `ALLOW_CHAT` varchar(1) NOT NULL,
  `VIEW_SLA` varchar(1) NOT NULL,
  `EXISTING_USER` varchar(1) NOT NULL,
  `REMOVE_ACCESS` varchar(1) NOT NULL,
  `USAGE_HISTORY` varchar(1) NOT NULL,
  `TEMPORARY_APPROVER_ID` bigint(20) NOT NULL,
  `BIZ_MSG_FLAG` varchar(1) NOT NULL,
  `AUDIT_FLAG` varchar(1) NOT NULL,
  `ALLOW_TK_FLAG` varchar(1) NOT NULL,
  `ALLOW_TIMEZONE` varchar(1) NOT NULL,
  `DEFAULT_TIMEZONE` varchar(240) NOT NULL,
  `DEFAULT_DATE_FORMAT` varchar(20) NOT NULL,
  `ENABLE_PA` varchar(1) NOT NULL,
  `ALLOW_NEGATIVE` varchar(1) NOT NULL,
  `DISPLAY_BUDGET` varchar(1) NOT NULL,
  `UPDATE_SUBMITTED` varchar(1) NOT NULL,
  `OVERRIDE_PRIMARY` varchar(1) NOT NULL,
  `RECENT_TIMECARDS` double NOT NULL,
  `RETRO_ADJUST` varchar(1) NOT NULL,
  `MAX_DAILY_LIMIT` double NOT NULL,
  `AFT_ENTRY` varchar(1) NOT NULL,
  `ENFORCE_TIME_WBS` varchar(1) NOT NULL,
  `CREATE_EMP_ALIAS_FLAG` varchar(1) NOT NULL,
  `RETRO_PERIOD_NUM` double NOT NULL,
  `ALLOW_COPY` varchar(1) NOT NULL,
  `COPY_ANYONE_TS_FLAG` varchar(1) NOT NULL,
  `APPROVE_ANYONE_TS` varchar(1) NOT NULL,
  `CREATE_ANYONE_TS` varchar(1) NOT NULL,
  `APPROVE_ANYONE_TS_TEAM` varchar(1) NOT NULL,
  `ALLOW_SUP_TS` varchar(1) NOT NULL,
  `ADVANCE_FOR_OVERTIME` varchar(1) NOT NULL,
  `ALLOW_PREAPPROVAL` varchar(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cxs_am_roles`
--

INSERT INTO `cxs_am_roles` (`ROLE_ID`, `ROLE_NAME`, `DESCRIPTION`, `CREATED_BY`, `LAST_UPDATED_BY`, `CREATION_DATE`, `LAST_UPDATE_DATE`, `CREATE_NEW_USER`, `VIEW_ONLY`, `UPDATE_ONLY`, `VIEW_SUBSCRIBERS`, `SUBMIT_CUSTOM`, `ALLOW_CHAT`, `VIEW_SLA`, `EXISTING_USER`, `REMOVE_ACCESS`, `USAGE_HISTORY`, `TEMPORARY_APPROVER_ID`, `BIZ_MSG_FLAG`, `AUDIT_FLAG`, `ALLOW_TK_FLAG`, `ALLOW_TIMEZONE`, `DEFAULT_TIMEZONE`, `DEFAULT_DATE_FORMAT`, `ENABLE_PA`, `ALLOW_NEGATIVE`, `DISPLAY_BUDGET`, `UPDATE_SUBMITTED`, `OVERRIDE_PRIMARY`, `RECENT_TIMECARDS`, `RETRO_ADJUST`, `MAX_DAILY_LIMIT`, `AFT_ENTRY`, `ENFORCE_TIME_WBS`, `CREATE_EMP_ALIAS_FLAG`, `RETRO_PERIOD_NUM`, `ALLOW_COPY`, `COPY_ANYONE_TS_FLAG`, `APPROVE_ANYONE_TS`, `CREATE_ANYONE_TS`, `APPROVE_ANYONE_TS_TEAM`, `ALLOW_SUP_TS`, `ADVANCE_FOR_OVERTIME`, `ALLOW_PREAPPROVAL`) VALUES
(1, 'Role 1', 'desc 1', 1, 20, '2017-12-29', '2017-12-29', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', 'Y', 0, 'Y', 'Y', 'N', 'N', '', '', 'N', 'Y', 'N', 'Y', 'Y', 50, 'Y', 20, 'Y', 'N', 'Y', 30, 'Y', 'Y', 'Y', 'Y', 'N', 'N', 'Y', 'N'),
(2, 'Role 2', 'description 2', 1, 20, '2017-12-29', '2017-12-29', 'N', 'Y', 'Y', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 0, 'N', 'N', 'N', 'N', '', '', 'N', 'N', '', 'N', 'N', 0, 'N', 24, 'N', 'N', 'N', 0, 'N', 'N', 'Y', 'N', 'N', 'N', 'Y', 'Y'),
(3, 'Role 3', 'Role Desc 3', 1, 0, '2018-01-02', '0000-00-00', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 0, 'N', 'N', 'N', 'N', 'Option 1', 'mm/dd/yyyy', 'N', 'N', 'N', 'N', 'N', 0, 'N', 24, 'N', 'N', 'N', 0, 'N', 'N', 'N', 'N', '', '', '', ''),
(4, 'Role 4', 'Role desc 4', 1, 0, '2018-01-02', '0000-00-00', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 0, 'N', 'N', 'N', 'N', '', '', 'N', 'N', '', 'N', 'N', 0, 'N', 0, 'N', 'N', 'N', 0, 'N', 'N', 'N', 'N', '', '', '', ''),
(5, 'Role 5', 'Role desc 5', 1, 0, '2018-01-02', '0000-00-00', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 0, 'N', 'N', 'N', 'N', '', '', 'N', 'N', 'N', 'N', 'N', 0, 'N', 24, 'N', 'N', 'N', 0, 'N', 'N', 'N', 'N', '', '', '', ''),
(6, 'Role 6', 'Role desc 6', 1, 0, '0000-00-00', '0000-00-00', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 0, 'N', 'N', 'N', 'N', '', '', 'N', 'N', '', 'N', 'N', 0, 'N', 24, 'N', 'N', 'N', 0, 'N', 'N', 'N', 'N', '', '', '', ''),
(7, 'Role 7', 'role desc 7', 1, 20, '0000-00-00', '0000-00-00', 'Y', 'N', 'N', 'Y', 'Y', 'N', 'N', 'Y', 'N', 'N', 0, 'N', 'N', 'N', 'N', '', '', 'N', 'N', '', 'N', 'N', 0, 'N', 24, 'N', 'N', 'N', 0, 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(8, 'test role', 'TEST DESC', 20, 20, '2018-01-08', '0000-00-00', 'Y', 'N', 'N', 'N', 'N', '', 'N', 'N', 'N', 'N', 0, 'N', 'Y', 'N', 'N', '', '', 'N', 'N', '', 'N', 'N', 0, 'N', 24, 'N', '', '', 0, 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `cxs_am_ta_rules`
--

CREATE TABLE IF NOT EXISTS `cxs_am_ta_rules` (
  `USER_ID` bigint(20) NOT NULL,
  `CREATED_BY` bigint(20) NOT NULL,
  `CREATION_DATE` date NOT NULL,
  `LAST_UPDATED_BY` bigint(20) NOT NULL,
  `LAST_UPDATE_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `BIZ_MSG_FLAG` varchar(1) NOT NULL,
  `AUDIT_FLAG` varchar(1) NOT NULL,
  `ALLOW_TK_FLAG` varchar(1) NOT NULL,
  `ALLOW_TIMEZONE` varchar(1) NOT NULL,
  `DEFAULT_TIMEZONE` varchar(240) NOT NULL,
  `DEFAULT_DATE_FORMAT` varchar(20) NOT NULL,
  `ENABLE_PA` varchar(1) NOT NULL,
  `ALLOW_NEGATIVE` varchar(1) NOT NULL,
  `DISPLAY_BUDGET` varchar(1) NOT NULL,
  `UPDATE_SUBMITTED` varchar(1) NOT NULL,
  `OVERRIDE_PRIMARY` varchar(1) NOT NULL,
  `RECENT_TIMECARDS` double NOT NULL,
  `RETRO_ADJUST` varchar(1) NOT NULL,
  `MAX_DAILY_LIMIT` double NOT NULL,
  `AFT_ENTRY` varchar(1) NOT NULL,
  `ENFORCE_TIME_WBS` varchar(1) NOT NULL,
  `CREATE_EMP_ALIAS_FLAG` varchar(1) NOT NULL,
  `RETRO_PERIOD_NUM` double NOT NULL,
  `ALLOW_COPY` varchar(1) NOT NULL,
  `COPY_ANYONE_TS_FLAG` varchar(1) NOT NULL,
  `APPROVE_ANYONE_TS` varchar(1) NOT NULL,
  `CREATE_ANYONE_TS` varchar(1) NOT NULL,
  `APPROVE_ANYONE_TS_TEAM` varchar(1) NOT NULL,
  `ALLOW_SUP_TS` varchar(1) NOT NULL,
  `ADVANCE_FOR_OVERTIME` varchar(1) NOT NULL,
  `ALLOW_PREAPPROVAL` varchar(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cxs_am_ta_rules`
--

INSERT INTO `cxs_am_ta_rules` (`USER_ID`, `CREATED_BY`, `CREATION_DATE`, `LAST_UPDATED_BY`, `LAST_UPDATE_DATE`, `BIZ_MSG_FLAG`, `AUDIT_FLAG`, `ALLOW_TK_FLAG`, `ALLOW_TIMEZONE`, `DEFAULT_TIMEZONE`, `DEFAULT_DATE_FORMAT`, `ENABLE_PA`, `ALLOW_NEGATIVE`, `DISPLAY_BUDGET`, `UPDATE_SUBMITTED`, `OVERRIDE_PRIMARY`, `RECENT_TIMECARDS`, `RETRO_ADJUST`, `MAX_DAILY_LIMIT`, `AFT_ENTRY`, `ENFORCE_TIME_WBS`, `CREATE_EMP_ALIAS_FLAG`, `RETRO_PERIOD_NUM`, `ALLOW_COPY`, `COPY_ANYONE_TS_FLAG`, `APPROVE_ANYONE_TS`, `CREATE_ANYONE_TS`, `APPROVE_ANYONE_TS_TEAM`, `ALLOW_SUP_TS`, `ADVANCE_FOR_OVERTIME`, `ALLOW_PREAPPROVAL`) VALUES
(1, 1, '2017-09-06', 1, '2017-12-14 11:16:21', 'Y', 'Y', 'Y', 'N', 'Option 1', 'mm/dd/yyyy', 'N', 'Y', 'N', 'Y', 'Y', 50, 'Y', 20, 'Y', 'N', 'Y', 30, 'Y', 'Y', 'Y', 'Y', 'N', 'N', 'Y', 'N'),
(3, 1, '2017-09-09', 1, '2017-09-09 10:42:38', 'N', 'N', 'N', 'N', 'Option 1', 'mm/dd/yyyy', 'N', 'N', 'N', 'N', 'N', 0, 'N', 24, 'N', 'N', 'N', 0, 'N', 'N', 'N', 'N', 'N', 'N', '', ''),
(5, 1, '2017-10-25', 1, '2017-12-29 14:38:17', 'N', 'N', 'N', 'N', '', '', 'N', 'N', 'N', 'N', 'N', 0, 'N', 24, 'N', 'N', 'N', 0, 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(15, 1, '2017-10-25', 1, '2017-10-25 07:28:11', 'N', 'N', 'N', 'N', 'Option 1', 'mm/dd/yyyy', 'N', 'N', 'N', 'N', 'N', 0, 'N', 24, 'N', 'N', 'N', 0, 'N', 'N', 'N', 'N', 'N', 'N', '', ''),
(2, 1, '2017-11-09', 1, '2017-12-29 13:35:06', 'N', 'N', 'N', 'N', '', '', 'N', 'N', '', 'N', 'N', 0, 'N', 24, 'N', 'N', 'N', 0, 'N', 'N', 'Y', 'N', 'N', 'N', 'Y', 'Y'),
(7, 1, '2017-12-15', 1, '2017-12-15 09:46:39', 'N', 'N', 'N', 'N', 'Option 1', 'mm/dd/yyyy', 'N', 'N', '', 'N', 'N', 0, 'N', 24, 'N', 'N', 'N', 0, 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(4, 1, '2018-01-02', 1, '2018-01-02 09:22:23', 'N', 'N', 'N', 'N', '', '', 'N', 'N', '', 'N', 'N', 0, 'N', 0, 'N', 'N', 'N', 0, 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `cxs_am_user_admin`
--

CREATE TABLE IF NOT EXISTS `cxs_am_user_admin` (
  `USER_ID` bigint(20) NOT NULL,
  `CREATED_BY` bigint(20) NOT NULL,
  `CREATION_DATE` datetime NOT NULL,
  `LAST_UPDATED_BY` bigint(20) NOT NULL,
  `LAST_UPDATE_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CREATE_NEW_USER` varchar(1) NOT NULL,
  `VIEW_ONLY` varchar(1) NOT NULL,
  `UPDATE_ONLY` varchar(1) NOT NULL,
  `VIEW_SUBSCRIBERS` varchar(1) NOT NULL,
  `SUBMIT_CUSTOM` varchar(1) NOT NULL,
  `ALLOW_CHAT` varchar(1) NOT NULL,
  `VIEW_SLA` varchar(1) NOT NULL,
  `EXISTING_USER` varchar(1) NOT NULL,
  `REMOVE_ACCESS` varchar(1) NOT NULL,
  `USAGE_HISTORY` varchar(1) NOT NULL,
  `TEMPORARY_APPROVER_ID` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cxs_am_user_admin`
--

INSERT INTO `cxs_am_user_admin` (`USER_ID`, `CREATED_BY`, `CREATION_DATE`, `LAST_UPDATED_BY`, `LAST_UPDATE_DATE`, `CREATE_NEW_USER`, `VIEW_ONLY`, `UPDATE_ONLY`, `VIEW_SUBSCRIBERS`, `SUBMIT_CUSTOM`, `ALLOW_CHAT`, `VIEW_SLA`, `EXISTING_USER`, `REMOVE_ACCESS`, `USAGE_HISTORY`, `TEMPORARY_APPROVER_ID`) VALUES
(1, 1, '2017-09-06 18:05:38', 1, '2017-12-14 11:16:28', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 0),
(3, 1, '2017-09-09 16:12:38', 1, '2017-09-09 10:42:38', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 0),
(5, 1, '2017-10-25 12:54:26', 1, '2017-10-25 07:24:26', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 0),
(15, 1, '2017-10-25 12:58:11', 1, '2017-10-25 07:28:11', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 0),
(2, 1, '2017-11-09 14:07:52', 1, '2017-12-29 14:37:25', 'N', 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 0),
(7, 1, '2017-12-15 15:16:39', 1, '2017-12-15 09:46:39', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 0),
(4, 1, '2018-01-02 14:52:23', 1, '2018-01-02 09:22:23', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cxs_application_assignments`
--

CREATE TABLE IF NOT EXISTS `cxs_application_assignments` (
  `CREATION_DATE` datetime DEFAULT NULL,
  `LAST_UPDATE_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CREATED_BY` bigint(20) NOT NULL,
  `LAST_UPDATED_BY` bigint(20) NOT NULL,
  `ASSIGNMENT_ID` bigint(20) NOT NULL,
  `APPLICATION_ROLE_ID` bigint(20) NOT NULL,
  `ROLE_START_DATE` date DEFAULT NULL,
  `ROLE_END_DATE` date DEFAULT NULL,
  `USER_ID` bigint(20) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cxs_application_assignments`
--

INSERT INTO `cxs_application_assignments` (`CREATION_DATE`, `LAST_UPDATE_DATE`, `CREATED_BY`, `LAST_UPDATED_BY`, `ASSIGNMENT_ID`, `APPLICATION_ROLE_ID`, `ROLE_START_DATE`, `ROLE_END_DATE`, `USER_ID`) VALUES
('2017-09-07 12:02:41', '2017-09-07 06:32:41', 2, 2, 1, 1, '2017-09-09', NULL, 4),
('2018-01-02 16:13:37', '2018-01-02 10:43:37', 2, 2, 10, 1, '2018-01-02', '2018-01-02', 18),
('2018-01-02 16:05:03', '2018-01-02 10:35:03', 2, 2, 9, 1, '2018-01-02', '2018-02-09', 17),
('2017-11-07 17:18:14', '2017-11-07 11:48:14', 2, 2, 7, 3, '2017-11-01', '2017-11-18', 5),
('2017-12-08 13:22:50', '2017-12-08 07:52:50', 2, 2, 8, 4, '2017-12-05', '2017-12-15', 10);

-- --------------------------------------------------------

--
-- Table structure for table `cxs_application_roles`
--

CREATE TABLE IF NOT EXISTS `cxs_application_roles` (
  `APPLICATION_ROLE_ID` bigint(20) NOT NULL,
  `ROLE_NAME` varchar(40) DEFAULT NULL,
  `CREATION_DATE` datetime NOT NULL,
  `CREATED_BY` bigint(20) NOT NULL,
  `LAST_UPDATE_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `LAST_UPDATED_BY` bigint(20) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cxs_application_roles`
--

INSERT INTO `cxs_application_roles` (`APPLICATION_ROLE_ID`, `ROLE_NAME`, `CREATION_DATE`, `CREATED_BY`, `LAST_UPDATE_DATE`, `LAST_UPDATED_BY`) VALUES
(1, 'Role 1', '0000-00-00 00:00:00', 0, '2017-08-17 11:25:50', 0),
(2, 'Role 2', '0000-00-00 00:00:00', 0, '2017-08-17 11:25:55', 0),
(3, 'Role 3', '0000-00-00 00:00:00', 0, '2017-08-17 11:25:58', 0),
(4, 'Role 4', '0000-00-00 00:00:00', 0, '2017-08-17 11:26:02', 0),
(5, 'Role 5', '0000-00-00 00:00:00', 0, '2017-08-24 12:10:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cxs_common_words`
--

CREATE TABLE IF NOT EXISTS `cxs_common_words` (
  `COMMON_WORD_ID` bigint(20) NOT NULL,
  `WORD_NAME` varchar(240) DEFAULT '',
  `ACTIVE_FLAG` varchar(1) DEFAULT '',
  `CREATED_BY` bigint(20) NOT NULL,
  `CREATION_DATE` date NOT NULL,
  `LAST_UPDATED_BY` bigint(20) NOT NULL,
  `LAST_UPDATE_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cxs_common_words`
--

INSERT INTO `cxs_common_words` (`COMMON_WORD_ID`, `WORD_NAME`, `ACTIVE_FLAG`, `CREATED_BY`, `CREATION_DATE`, `LAST_UPDATED_BY`, `LAST_UPDATE_DATE`) VALUES
(1, 'abct890', '1', 0, '2017-12-06', 0, '2017-12-07 11:28:55'),
(2, 'test', '1', 0, '2017-12-06', 0, '2017-12-06 15:03:33'),
(3, 'abcd4588886', '1', 0, '2017-12-06', 0, '2017-12-07 11:20:59'),
(4, 'New Changes', '1', 0, '2017-12-06', 0, '2017-12-07 11:20:59'),
(5, 'xyz', '0', 0, '2017-12-06', 0, '2017-12-06 10:22:41'),
(6, 'sample 678', '1', 0, '2017-12-06', 0, '2017-12-06 15:09:10'),
(7, 'aoioi', '0', 0, '2017-12-06', 0, '2017-12-07 11:07:02'),
(8, 'ablkjkjk', '0', 0, '2017-12-06', 0, '2017-12-07 11:07:02'),
(9, 'ax', '1', 0, '2017-12-07', 0, '2017-12-07 11:17:08'),
(10, '434343434', '0', 0, '2017-12-07', 0, '2017-12-07 11:22:23'),
(11, 'New Word', '1', 0, '2017-12-07', 0, '2017-12-07 11:29:14'),
(12, 'testtt', '1', 0, '2017-12-07', 0, '2017-12-12 06:59:30'),
(13, 'p1', '1', 0, '2017-12-07', 0, '2017-12-07 13:15:41'),
(14, 'New Changes 2', '0', 0, '2017-12-07', 0, '2017-12-07 13:46:34'),
(15, 'New Changes 1', '0', 0, '2017-12-07', 0, '2017-12-07 13:46:34'),
(16, 'NewChanges', '0', 0, '2017-12-07', 0, '2017-12-07 13:38:47'),
(17, 'abc xyz', '0', 0, '2017-12-07', 0, '2017-12-07 13:51:59'),
(18, 'Demo', '0', 0, '2017-12-07', 0, '2017-12-07 14:00:43');

-- --------------------------------------------------------

--
-- Table structure for table `cxs_holiday_calendar`
--

CREATE TABLE IF NOT EXISTS `cxs_holiday_calendar` (
  `HOLIDAY_CALENDAR_ID` bigint(20) NOT NULL,
  `CALENDAR_NAME` varchar(40) NOT NULL DEFAULT '',
  `ACTIVE_FLAG` varchar(1) NOT NULL DEFAULT '',
  `INUSE_FLAG` varchar(1) NOT NULL DEFAULT '',
  `PERIOD_ID` bigint(20) NOT NULL DEFAULT '0',
  `HOLIDAY_TAG_NAME` varchar(40) NOT NULL DEFAULT '',
  `DESCRIPTION` varchar(240) NOT NULL DEFAULT '',
  `HOLIDAY_START_DATE` date DEFAULT NULL,
  `HOLIDAY_END_DATE` date DEFAULT NULL,
  `ENFORCE_FLAG` varchar(1) NOT NULL DEFAULT '',
  `RECESS_ALLOWED` varchar(1) NOT NULL DEFAULT '',
  `ENABLED_FLAG` varchar(1) NOT NULL DEFAULT '',
  `LAST_SESSION_ID` varchar(240) NOT NULL DEFAULT '',
  `CREATED_BY` bigint(20) NOT NULL,
  `CREATION_DATE` date NOT NULL,
  `LAST_UPDATED_BY` bigint(20) NOT NULL,
  `LAST_UPDATE_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cxs_holiday_calendar`
--

INSERT INTO `cxs_holiday_calendar` (`HOLIDAY_CALENDAR_ID`, `CALENDAR_NAME`, `ACTIVE_FLAG`, `INUSE_FLAG`, `PERIOD_ID`, `HOLIDAY_TAG_NAME`, `DESCRIPTION`, `HOLIDAY_START_DATE`, `HOLIDAY_END_DATE`, `ENFORCE_FLAG`, `RECESS_ALLOWED`, `ENABLED_FLAG`, `LAST_SESSION_ID`, `CREATED_BY`, `CREATION_DATE`, `LAST_UPDATED_BY`, `LAST_UPDATE_DATE`) VALUES
(1, '2017-18', 'Y', 'N', 2, 'a', 'aa', '2017-01-01', '2017-01-01', 'Y', 'N', 'N', '', 1, '2017-11-27', 1, '2017-11-28 05:10:25'),
(2, '2017-18', 'Y', 'Y', 3, 'b', 'bb', '2017-02-02', '2017-02-05', 'Y', 'N', 'Y', '', 1, '2017-11-27', 1, '2017-11-28 05:10:25'),
(3, '2017-18', 'Y', 'Y', 2, 'c', 'cc', '2017-03-02', '2017-03-17', 'Y', 'N', 'Y', '', 1, '2017-11-27', 1, '2017-11-28 05:10:41'),
(4, '2018-19', 'N', 'N', 4, 'd', 'dd', '2017-04-04', '2017-04-30', 'Y', 'N', 'Y', '', 1, '2017-11-27', 1, '2017-11-28 05:06:31');

-- --------------------------------------------------------

--
-- Table structure for table `cxs_password_reuse`
--

CREATE TABLE IF NOT EXISTS `cxs_password_reuse` (
  `USER_ID` int(11) NOT NULL,
  `LAST_UPDATE_DATE` date NOT NULL,
  `LAST_UPDATED_BY` bigint(15) NOT NULL,
  `CREATION_DATE` date NOT NULL,
  `CREATED_BY` bigint(15) NOT NULL,
  `XXT_PASSWORD` varchar(100) NOT NULL,
  `KOUNTER` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cxs_periods`
--

CREATE TABLE IF NOT EXISTS `cxs_periods` (
  `PERIOD_ID` bigint(20) NOT NULL,
  `FROM_PERIOD_DATE` date NOT NULL,
  `TO_PERIOD_DATE` date NOT NULL,
  `PERIOD_YEAR` varchar(50) NOT NULL DEFAULT '',
  `PERIOD_NAME` varchar(50) NOT NULL DEFAULT '',
  `STATUS` varchar(50) NOT NULL DEFAULT '',
  `ENTITY_ID` bigint(20) NOT NULL DEFAULT '0',
  `LAST_SESSION_ID` varchar(240) NOT NULL DEFAULT '',
  `CREATED_BY` bigint(20) NOT NULL,
  `CREATION_DATE` date NOT NULL,
  `LAST_UPDATED_BY` bigint(20) NOT NULL,
  `LAST_UPDATE_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `FLAG_INUSE` varchar(1) NOT NULL DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cxs_periods`
--

INSERT INTO `cxs_periods` (`PERIOD_ID`, `FROM_PERIOD_DATE`, `TO_PERIOD_DATE`, `PERIOD_YEAR`, `PERIOD_NAME`, `STATUS`, `ENTITY_ID`, `LAST_SESSION_ID`, `CREATED_BY`, `CREATION_DATE`, `LAST_UPDATED_BY`, `LAST_UPDATE_DATE`, `FLAG_INUSE`) VALUES
(1, '2017-11-01', '2017-11-02', '', 'test', 'Close', 0, '', 1, '2017-11-24', 1, '2017-11-25 05:11:02', 'N'),
(2, '2017-11-01', '2017-11-03', '', 'A', 'In Use', 0, '', 1, '2017-11-24', 1, '2017-11-25 05:32:57', 'N'),
(3, '2017-11-02', '2017-11-25', '', 'zz', 'Permanently Closed', 0, '', 1, '2017-11-24', 1, '2017-11-25 05:14:50', 'Y'),
(4, '2017-11-16', '2017-11-28', '', 'f', 'Never Opened', 0, '', 1, '2017-11-24', 1, '2017-11-24 11:03:31', 'N'),
(5, '2017-11-02', '2017-12-01', 'f', 'ff', 'Close', 0, '', 1, '2017-11-24', 1, '2017-11-25 05:11:02', 'Y'),
(6, '2017-11-03', '2017-11-03', '', 'aa', 'Open', 0, '', 1, '2017-11-24', 1, '2017-11-24 11:44:06', 'Y'),
(7, '2017-11-17', '2017-11-23', '', 'aaa', 'Never Opened', 0, '', 1, '2017-11-24', 1, '2017-11-24 11:09:43', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `cxs_policy_header`
--

CREATE TABLE IF NOT EXISTS `cxs_policy_header` (
  `POLICY_ID` bigint(20) NOT NULL,
  `NAME` varchar(240) NOT NULL DEFAULT '',
  `DESCRIPTION` varchar(240) NOT NULL DEFAULT '',
  `ACTIVE_FLAG` varchar(1) NOT NULL DEFAULT '',
  `CREATED_BY` bigint(20) NOT NULL,
  `CREATION_DATE` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` bigint(10) NOT NULL,
  `LAST_UPDATED` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cxs_policy_header`
--

INSERT INTO `cxs_policy_header` (`POLICY_ID`, `NAME`, `DESCRIPTION`, `ACTIVE_FLAG`, `CREATED_BY`, `CREATION_DATE`, `LAST_UPDATED_BY`, `LAST_UPDATED`) VALUES
(1, 'policy 1', '', '', 0, NULL, 0, '2017-09-28 11:38:10');

-- --------------------------------------------------------

--
-- Table structure for table `cxs_preapp_rules`
--

CREATE TABLE IF NOT EXISTS `cxs_preapp_rules` (
  `PREAPP_RULE_ID` bigint(20) NOT NULL,
  `PREAPPROVAL_TYPE` varchar(100) NOT NULL DEFAULT '',
  `QUOTA_HOURS` double NOT NULL DEFAULT '0',
  `CHARGE_TYPE` varchar(10) NOT NULL DEFAULT '',
  `BUDGET_HOURS` double NOT NULL DEFAULT '0',
  `TOLERANCE` double NOT NULL DEFAULT '0',
  `ENFORCE_FLAG` varchar(1) NOT NULL DEFAULT '',
  `HOLIDAY_FLAG` varchar(1) NOT NULL DEFAULT '',
  `WEEKEND_HOURS_FLAG` varchar(1) NOT NULL DEFAULT '',
  `PERIOD_ID` bigint(20) NOT NULL DEFAULT '0',
  `PROJECT_ID` bigint(20) NOT NULL DEFAULT '0',
  `WBS_COMBINATION_ID` bigint(20) NOT NULL DEFAULT '0',
  `BUDGET_AMOUNT` double NOT NULL DEFAULT '0',
  `LAST_SESSION_ID` varchar(240) NOT NULL DEFAULT '',
  `CREATED_BY` bigint(20) NOT NULL,
  `CREATION_DATE` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` bigint(10) NOT NULL,
  `LAST_UPDATED` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cxs_resources`
--

CREATE TABLE IF NOT EXISTS `cxs_resources` (
  `RESOURCE_ID` bigint(20) NOT NULL,
  `FIRST_NAME` varchar(240) NOT NULL DEFAULT '',
  `MIDDLE_NAME` varchar(240) NOT NULL DEFAULT '',
  `LAST_NAME` varchar(240) NOT NULL DEFAULT '',
  `PREAPPROVAL_FLAG` varchar(1) NOT NULL DEFAULT 'N',
  `RESOURCE_TYPE` varchar(100) NOT NULL,
  `CONTRACTOR_TYPE_FLAG` varchar(100) NOT NULL DEFAULT '',
  `PARTY_ID` bigint(20) NOT NULL,
  `CONTRACT_ID` bigint(20) NOT NULL,
  `DEPARTMENT_ID` bigint(20) NOT NULL,
  `START_DATE_ACTIVE` date DEFAULT NULL,
  `END_DATE_ACTIVE` date DEFAULT NULL,
  `TIMEMANAGEMENTPOLICY_ID` bigint(20) NOT NULL,
  `PREAPPROVALRULES_ID` bigint(20) NOT NULL,
  `SUPREVISOR_ID` bigint(20) NOT NULL,
  `JOB_CLASSIFICATION` varchar(240) NOT NULL,
  `DESCRIPTION` varchar(240) NOT NULL,
  `ENTITY_ID` bigint(20) NOT NULL,
  `RBAC_ID` bigint(20) NOT NULL,
  `RESOURCE_GROUP_ID` bigint(20) NOT NULL,
  `CREATED_BY` bigint(20) NOT NULL,
  `CREATION_DATE` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` bigint(10) NOT NULL,
  `LAST_UPDATE_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `LAST_SESSION_ID` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cxs_resources`
--

INSERT INTO `cxs_resources` (`RESOURCE_ID`, `FIRST_NAME`, `MIDDLE_NAME`, `LAST_NAME`, `PREAPPROVAL_FLAG`, `RESOURCE_TYPE`, `CONTRACTOR_TYPE_FLAG`, `PARTY_ID`, `CONTRACT_ID`, `DEPARTMENT_ID`, `START_DATE_ACTIVE`, `END_DATE_ACTIVE`, `TIMEMANAGEMENTPOLICY_ID`, `PREAPPROVALRULES_ID`, `SUPREVISOR_ID`, `JOB_CLASSIFICATION`, `DESCRIPTION`, `ENTITY_ID`, `RBAC_ID`, `RESOURCE_GROUP_ID`, `CREATED_BY`, `CREATION_DATE`, `LAST_UPDATED_BY`, `LAST_UPDATE_DATE`, `LAST_SESSION_ID`) VALUES
(1, 'aa', '', 'dd', 'N', 'Contractor', '', 0, 0, 0, '2017-10-10', '0000-00-00', 0, 0, 2, '', '', 0, 0, 1, 1, '2017-10-26 15:21:46', 1, '2017-12-15 08:08:14', 0),
(2, 'awq', '', 'dd', 'N', 'Contractor', '', 0, 0, 0, '2017-10-18', '0000-00-00', 0, 0, 3, '', '', 0, 0, 2, 1, '2017-10-11 13:30:44', 1, '2017-12-15 08:08:25', 0),
(3, 'Under', '', 'Resource Group', 'N', 'Employee', '', 0, 0, 0, '2017-10-23', '0000-00-00', 0, 0, 2, '', '', 0, 0, 2, 1, '2017-10-11 13:18:43', 1, '2018-01-11 16:05:34', 0),
(5, 'No', '', 'Resource Group', 'N', 'Contractor', '', 0, 0, 0, '2017-09-27', '0000-00-00', 0, 0, 2, '', '', 0, 0, 0, 1, '2017-10-11 13:19:37', 1, '2018-01-11 16:01:04', 0),
(6, 'aaa', '', 'ff', 'N', 'Contractor', '', 0, 0, 0, '2017-09-27', '0000-00-00', 0, 0, 1, '', '', 0, 0, 5, 1, '2017-10-11 13:20:14', 1, '2017-12-15 08:08:58', 0),
(7, 'aaa', '', 'ff', 'N', 'Contractor', '', 0, 0, 0, '2017-09-27', '0000-00-00', 0, 0, 0, '', '', 0, 0, 5, 1, '2017-10-11 13:25:14', 1, '2017-12-15 08:09:09', 0),
(8, 'aaa', '', 'ff', 'N', 'Contractor', '', 0, 0, 0, '2017-09-27', '0000-00-00', 0, 0, 2, '', '', 0, 0, 4, 1, '2017-10-11 13:28:50', 1, '2017-12-15 08:09:28', 0),
(9, 'aaa', '', 'ff', 'N', 'Contractor', '', 0, 0, 0, '2017-09-27', '0000-00-00', 0, 0, 0, '', '', 0, 0, 7, 1, '2017-10-11 13:29:04', 1, '2017-12-15 08:10:16', 0),
(10, 'aa', '', 'ff', 'N', 'External or Out of the organization resource', '', 0, 0, 0, '2017-10-19', '0000-00-00', 0, 0, 6, '', '', 0, 0, 3, 1, '2017-10-18 14:56:37', 1, '2017-12-15 08:09:41', 0),
(11, 'abc', '', 'eff', 'N', 'External or Out of the organization resource', '1099', 0, 0, 0, '2017-10-02', '0000-00-00', 0, 0, 6, '', '', 0, 0, 2, 1, '2017-10-26 15:25:14', 1, '2017-10-26 09:55:14', 0),
(12, 's', '', 's', 'N', 'Contractor', '', 0, 0, 0, '2017-09-28', '0000-00-00', 0, 0, 2, '', '', 0, 0, 0, 1, '2017-10-30 11:47:53', 1, '2017-10-30 06:17:53', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cxs_resource_address`
--

CREATE TABLE IF NOT EXISTS `cxs_resource_address` (
  `ADDRESS_RESOURCE_ID` bigint(20) NOT NULL,
  `RESOURCE_ID` bigint(20) NOT NULL,
  `ADDRESS1` varchar(100) NOT NULL DEFAULT '',
  `ADDRESS2` varchar(100) NOT NULL DEFAULT '',
  `ADDRESS3` varchar(100) NOT NULL DEFAULT '',
  `CITY` varchar(100) NOT NULL DEFAULT '',
  `STATE` varchar(100) NOT NULL DEFAULT '',
  `COUNTRY` varchar(100) NOT NULL DEFAULT '',
  `POSTAL_CODE` varchar(50) NOT NULL DEFAULT '',
  `PRIMARY_FLAG` varchar(1) NOT NULL DEFAULT '',
  `ACTIVE_FLAG` varchar(1) NOT NULL DEFAULT '',
  `LAST_SESSION_ID` varchar(240) NOT NULL DEFAULT '',
  `CREATED_BY` bigint(20) NOT NULL,
  `CREATION_DATE` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` bigint(10) NOT NULL,
  `LAST_UPDATE_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ROW_NO` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cxs_resource_address`
--

INSERT INTO `cxs_resource_address` (`ADDRESS_RESOURCE_ID`, `RESOURCE_ID`, `ADDRESS1`, `ADDRESS2`, `ADDRESS3`, `CITY`, `STATE`, `COUNTRY`, `POSTAL_CODE`, `PRIMARY_FLAG`, `ACTIVE_FLAG`, `LAST_SESSION_ID`, `CREATED_BY`, `CREATION_DATE`, `LAST_UPDATED_BY`, `LAST_UPDATE_DATE`, `ROW_NO`) VALUES
(1, 1, 'aa2', '', '', '', '', '', '', 'N', 'N', '', 1, '2017-10-11 12:20:14', 1, '2017-10-11 06:50:30', 1),
(2, 1, 'gg', '', '', '', '', '', '', 'N', 'N', '', 1, '2017-10-11 12:20:20', 1, '2017-10-11 06:50:20', 2),
(3, 1, 'dwew', '', '', '', '', '', '', 'N', 'N', '', 1, '2017-10-11 12:20:30', 1, '2017-10-11 06:51:12', 3),
(4, 1, 'g', 'gs', 'gd', '', '', '', '', 'N', 'N', '', 1, '2017-10-11 12:21:02', 1, '2017-10-11 06:51:02', 4),
(5, 1, 'ter', 'wew', '', 'ew', '', '', '', 'Y', 'N', '', 1, '2017-10-11 12:21:12', 1, '2017-10-11 06:51:12', 5),
(6, 2, 'fff', '', '', '', '', '', '', 'Y', 'N', '', 1, '2017-10-11 12:28:02', 1, '2017-10-11 06:58:02', 1),
(7, 3, 'g', 'aa', '', '', '', '', '', 'Y', 'N', '', 1, '2017-10-11 12:39:18', 1, '2017-12-18 13:17:01', 1),
(8, 3, 'w', 'a2', '', '', '', '', '', 'N', 'Y', '', 1, '2017-10-11 12:39:28', 1, '2017-12-18 13:15:14', 2),
(9, 10, 'ff', 'a1', 'qa', 'tt', 'abcd', 'ee', '25', 'Y', 'N', '', 1, '2017-10-18 14:56:47', 1, '2017-12-19 14:15:47', 1),
(10, 0, 'abcd2', 'abcd2', 'aa32', 'testCity', 'abcd', 'kdsfhk', '252525', 'N', 'Y', '', 0, '2017-12-18 19:24:25', 0, '2017-12-19 10:41:20', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cxs_resource_contact`
--

CREATE TABLE IF NOT EXISTS `cxs_resource_contact` (
  `CONTACT_RESOURCE_ID` bigint(20) NOT NULL,
  `RESOURCE_ID` bigint(20) NOT NULL,
  `PHONE_NUMBER` varchar(100) NOT NULL DEFAULT '',
  `EMAIL_ADDRESS` varchar(100) NOT NULL DEFAULT '',
  `PRIMARY_FLAG` varchar(1) NOT NULL DEFAULT '',
  `ACTIVE_FLAG` varchar(1) NOT NULL DEFAULT '',
  `ACCEPTS_TEXTS_FLAG` varchar(1) NOT NULL DEFAULT '',
  `SOCIAL_URL` varchar(100) NOT NULL DEFAULT '',
  `SOCIAL_URL_LABEL` varchar(240) NOT NULL DEFAULT '',
  `LAST_SESSION_ID` varchar(240) NOT NULL DEFAULT '',
  `CREATED_BY` bigint(20) NOT NULL,
  `CREATION_DATE` datetime NOT NULL,
  `LAST_UPDATED_BY` bigint(10) NOT NULL,
  `LAST_UPDATE_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ROW_NO` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cxs_resource_contact`
--

INSERT INTO `cxs_resource_contact` (`CONTACT_RESOURCE_ID`, `RESOURCE_ID`, `PHONE_NUMBER`, `EMAIL_ADDRESS`, `PRIMARY_FLAG`, `ACTIVE_FLAG`, `ACCEPTS_TEXTS_FLAG`, `SOCIAL_URL`, `SOCIAL_URL_LABEL`, `LAST_SESSION_ID`, `CREATED_BY`, `CREATION_DATE`, `LAST_UPDATED_BY`, `LAST_UPDATE_DATE`, `ROW_NO`) VALUES
(1, 1, '1234567', '44', 'N', 'N', 'N', '', '', '', 1, '2017-10-11 12:01:44', 1, '2017-10-11 06:36:43', 1),
(2, 1, '444', '', 'N', 'N', 'N', '', '', '', 1, '2017-10-11 12:01:55', 1, '2017-10-11 06:31:55', 2),
(7, 1, '8676', '', 'N', 'N', 'N', '', '', '', 1, '2017-10-11 12:06:43', 1, '2017-10-11 06:37:51', 3),
(8, 1, 'hhhh', '', 'N', 'N', 'N', '', '', '', 1, '2017-10-11 12:07:43', 1, '2017-10-11 06:37:43', 4),
(9, 1, 'e22', '', 'Y', 'N', 'N', '', '', '', 1, '2017-10-11 12:07:51', 1, '2017-10-11 06:37:51', 5),
(10, 2, 'f', '', 'Y', 'Y', 'Y', '', '', '', 1, '2017-10-11 12:30:33', 1, '2017-10-11 07:00:33', 1),
(11, 3, '222', '', 'N', 'N', 'N', '', '', '', 1, '2017-10-11 13:06:01', 1, '2017-10-11 07:38:29', 1),
(12, 3, '24444', '', 'Y', 'Y', 'Y', '', '', '', 1, '2017-10-11 13:06:17', 1, '2017-10-11 07:38:29', 2);

-- --------------------------------------------------------

--
-- Table structure for table `cxs_resource_groups`
--

CREATE TABLE IF NOT EXISTS `cxs_resource_groups` (
  `RESOURCE_GROUP_ID` bigint(20) NOT NULL,
  `RESOURCE_GROUP_NAME` varchar(40) NOT NULL,
  `DESCRIPTION` varchar(240) NOT NULL,
  `ACTIVE_FLAG` varchar(1) NOT NULL DEFAULT 'Y',
  `CREATED_BY` bigint(20) NOT NULL,
  `CREATION_DATE` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` bigint(10) NOT NULL,
  `LAST_UPDATE_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cxs_resource_groups`
--

INSERT INTO `cxs_resource_groups` (`RESOURCE_GROUP_ID`, `RESOURCE_GROUP_NAME`, `DESCRIPTION`, `ACTIVE_FLAG`, `CREATED_BY`, `CREATION_DATE`, `LAST_UPDATED_BY`, `LAST_UPDATE_DATE`) VALUES
(1, 'aa', '', 'Y', 1, '2017-10-26 12:21:08', 1, '2017-10-26 06:51:08'),
(2, 'bb', '', 'Y', 1, '2017-10-26 12:21:17', 1, '2017-10-26 07:06:55'),
(3, 'cc', '', 'Y', 1, '2017-10-26 12:21:20', 1, '2017-10-26 06:51:20'),
(4, 's', '', 'Y', 1, '2017-10-27 17:34:16', 1, '2017-10-27 12:04:16'),
(5, 'abc', '', 'Y', 1, '2017-10-27 17:41:09', 1, '2017-10-27 12:11:26'),
(6, 'test', '', 'Y', 1, '2017-11-21 11:42:59', 1, '2017-11-21 06:12:59'),
(7, 'a1', '', 'Y', 1, '2017-11-27 17:56:09', 1, '2017-11-27 12:26:31');

-- --------------------------------------------------------

--
-- Table structure for table `cxs_site_settings`
--

CREATE TABLE IF NOT EXISTS `cxs_site_settings` (
  `SITE_SETTINGS_ID` int(10) NOT NULL,
  `MANDATORY_PWD` bigint(20) NOT NULL,
  `INCORRECT_ATTEMPT` bigint(20) NOT NULL,
  `IDLE_SESSION` bigint(20) NOT NULL,
  `MINIMUM_ALLOWED` bigint(20) NOT NULL,
  `MAXIMUM_ALLOWED` bigint(20) NOT NULL,
  `DEFAULT_DATE_FORMAT` varchar(20) DEFAULT NULL,
  `DEFAULT_NUMBER_FORMAT` varchar(1) DEFAULT '',
  `DEFAULT_TIMEZONE` varchar(20) DEFAULT NULL,
  `ENFORCE_RECENT` varchar(1) DEFAULT '',
  `NUMBER_OF_RECENT` int(3) DEFAULT NULL,
  `ALLOW_SPECIALS` varchar(1) DEFAULT '',
  `ALLOW_UPPERCASE` varchar(1) DEFAULT '',
  `ALLOW_TIME_ENTRY` varchar(1) DEFAULT NULL,
  `ALLOW_LOWERCASE` varchar(1) DEFAULT '',
  `ALLOW_NUMERIC` varchar(1) DEFAULT '',
  `ENABLE_COMMON` varchar(1) DEFAULT '',
  `CREATED_BY` bigint(20) NOT NULL,
  `CREATION_DATE` date NOT NULL,
  `LAST_UPDATED_BY` bigint(20) NOT NULL,
  `LAST_UPDATE_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cxs_site_settings`
--

INSERT INTO `cxs_site_settings` (`SITE_SETTINGS_ID`, `MANDATORY_PWD`, `INCORRECT_ATTEMPT`, `IDLE_SESSION`, `MINIMUM_ALLOWED`, `MAXIMUM_ALLOWED`, `DEFAULT_DATE_FORMAT`, `DEFAULT_NUMBER_FORMAT`, `DEFAULT_TIMEZONE`, `ENFORCE_RECENT`, `NUMBER_OF_RECENT`, `ALLOW_SPECIALS`, `ALLOW_UPPERCASE`, `ALLOW_TIME_ENTRY`, `ALLOW_LOWERCASE`, `ALLOW_NUMERIC`, `ENABLE_COMMON`, `CREATED_BY`, `CREATION_DATE`, `LAST_UPDATED_BY`, `LAST_UPDATE_DATE`) VALUES
(1, 10, 25, 1243, 9, 0, 'm/d', '', 'Central', 'Y', 5, 'Y', 'Y', 'N', 'Y', 'Y', 'Y', 0, '2017-12-07', 0, '2017-12-12 14:08:05');

-- --------------------------------------------------------

--
-- Table structure for table `cxs_subscribers`
--

CREATE TABLE IF NOT EXISTS `cxs_subscribers` (
  `SUBSCRIBER_ID` bigint(20) NOT NULL,
  `USER_ID` bigint(20) NOT NULL,
  `FIRST_NAME` varchar(240) NOT NULL,
  `MIDDLE_INITIAL` varchar(40) NOT NULL,
  `LAST_NAME` varchar(240) NOT NULL,
  `CREATION_DATE` date NOT NULL,
  `LAST_UPDATE_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CREATED_BY` double NOT NULL,
  `LAST_UPDATED_BY` double NOT NULL,
  `START_DATE` date NOT NULL,
  `END_DATE` date NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cxs_subscribers`
--

INSERT INTO `cxs_subscribers` (`SUBSCRIBER_ID`, `USER_ID`, `FIRST_NAME`, `MIDDLE_INITIAL`, `LAST_NAME`, `CREATION_DATE`, `LAST_UPDATE_DATE`, `CREATED_BY`, `LAST_UPDATED_BY`, `START_DATE`, `END_DATE`) VALUES
(1, 0, 'aman', '', 'ss', '2017-09-06', '2017-09-15 08:33:41', 1, 1, '2017-09-15', '0000-00-00'),
(2, 0, 'Harry', '', 'roy', '2017-09-06', '2017-09-15 08:35:21', 1, 1, '2017-09-28', '0000-00-00'),
(3, 0, 'black', '', 'smith', '2017-09-06', '2017-09-15 08:34:04', 1, 1, '2017-09-04', '0000-00-00'),
(4, 0, 'jon', '', 'smith', '2017-09-06', '2017-09-15 08:34:35', 1, 1, '2017-09-15', '2017-09-22'),
(5, 2, 'aa', '', 'aa', '2017-09-06', '2017-12-15 13:33:09', 1, 1, '2017-09-28', '0000-00-00'),
(6, 0, 'Jerry', '', 'Williams', '2017-09-06', '2017-09-15 08:35:14', 1, 1, '1970-01-01', '0000-00-00'),
(7, 3, 'Mason', '', 'Williams', '2017-09-06', '2017-12-15 13:33:09', 1, 1, '2017-09-04', '0000-00-00'),
(8, 6, 'kalyan', '', 'dey', '2017-12-04', '2017-12-15 13:33:09', 1, 1, '1970-01-01', '0000-00-00'),
(9, 11, 'abcd', '', 'xyz', '2017-12-15', '2017-12-15 14:06:32', 1, 1, '2017-12-15', '2017-12-16'),
(10, 12, 'fnm', '', 'lnm', '2017-12-15', '2017-12-15 14:13:26', 1, 1, '2017-12-22', '2017-12-27'),
(11, 13, 'fsname', '', 'lname', '2017-12-15', '2017-12-15 14:21:00', 1, 1, '2017-12-21', '2017-12-22');

-- --------------------------------------------------------

--
-- Table structure for table `cxs_ta_modules`
--

CREATE TABLE IF NOT EXISTS `cxs_ta_modules` (
  `RESOURCE_GROUP_ID` int(11) DEFAULT NULL,
  `USER_ID` bigint(20) DEFAULT NULL,
  `MODULE_NAME` varchar(40) DEFAULT NULL,
  `CREATE_PRIV` varchar(1) DEFAULT NULL,
  `UPDATE_PRIV` varchar(1) DEFAULT NULL,
  `VIEW_PRIV` varchar(1) DEFAULT NULL,
  `ENABLE_AUDIT` varchar(1) DEFAULT NULL,
  `CREATED_BY` bigint(20) DEFAULT NULL,
  `CREATION_DATE` datetime NOT NULL,
  `LAST_UPDATED_BY` bigint(20) DEFAULT NULL,
  `LAST_UPDATE_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ROWNO` bigint(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cxs_ta_modules`
--

INSERT INTO `cxs_ta_modules` (`RESOURCE_GROUP_ID`, `USER_ID`, `MODULE_NAME`, `CREATE_PRIV`, `UPDATE_PRIV`, `VIEW_PRIV`, `ENABLE_AUDIT`, `CREATED_BY`, `CREATION_DATE`, `LAST_UPDATED_BY`, `LAST_UPDATE_DATE`, `ROWNO`) VALUES
(NULL, 20, 'Create WBS', 'N', 'N', 'Y', 'Y', 20, '2018-01-04 12:30:37', 20, '2018-01-04 07:00:37', 17),
(NULL, 20, 'Site Settings', 'N', 'N', 'Y', 'N', 20, '2018-01-04 12:30:37', 20, '2018-01-04 07:00:37', 15),
(NULL, 1, 'Time Management Policy', 'N', 'N', 'Y', 'N', 20, '2018-01-04 18:26:13', 20, '2018-01-04 12:56:13', 1),
(NULL, 5, 'Time Management Policy', 'Y', 'Y', 'N', 'N', 1, '2017-12-29 20:08:27', 1, '2017-12-29 14:38:27', 1),
(NULL, 5, 'PreApproval Rules', 'Y', 'N', 'N', 'N', 1, '2017-12-29 20:08:27', 1, '2017-12-29 14:38:27', 13),
(NULL, 5, 'Accounting Period', 'Y', 'Y', 'N', 'N', 1, '2017-12-29 20:08:27', 1, '2017-12-29 14:38:27', 14),
(2, NULL, 'Manage Payment Methods', 'N', 'N', 'N', 'Y', 20, '2018-01-11 12:59:47', 20, '2018-01-11 07:29:47', 22),
(2, NULL, 'Global Aliases', 'N', 'Y', 'N', 'N', 20, '2018-01-11 12:59:47', 20, '2018-01-11 07:29:47', 7),
(2, NULL, 'Time Entry', 'N', 'Y', 'N', 'N', 20, '2018-01-11 12:59:47', 20, '2018-01-11 07:29:47', 6),
(2, NULL, 'Holiday Calenders', 'N', 'N', 'Y', 'N', 20, '2018-01-11 12:59:47', 20, '2018-01-11 07:29:47', 2),
(6, NULL, 'Holiday Calenders', 'Y', 'N', 'N', 'N', 21, '2018-01-05 21:23:00', 21, '2018-01-05 15:53:00', 2),
(1, NULL, 'Site Settings', 'N', 'N', 'Y', 'N', 21, '2018-01-04 20:47:44', 21, '2018-01-04 15:17:44', 15),
(NULL, 1, 'Holiday Calenders', 'N', 'N', 'Y', 'N', 20, '2018-01-04 18:26:13', 20, '2018-01-04 12:56:13', 2),
(2, NULL, 'Time Management Policy', 'N', 'N', 'Y', 'N', 20, '2018-01-11 12:59:47', 20, '2018-01-11 07:29:47', 1),
(NULL, 15, 'Create WBS', 'N', 'Y', 'N', 'N', 20, '2018-01-04 16:59:55', 20, '2018-01-04 11:29:55', 17),
(NULL, 15, 'Accounting Period', 'Y', 'N', 'N', 'N', 20, '2018-01-04 16:59:55', 20, '2018-01-04 11:29:55', 14),
(NULL, 15, 'Time Management Policy', 'N', 'N', 'Y', 'N', 20, '2018-01-04 16:59:55', 20, '2018-01-04 11:29:55', 1),
(NULL, 2, 'Time Management Policy', 'N', 'N', 'Y', 'N', 20, '2018-01-11 21:30:19', 20, '2018-01-11 16:00:19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cxs_temp_approver`
--

CREATE TABLE IF NOT EXISTS `cxs_temp_approver` (
  `USER_ID` bigint(20) NOT NULL,
  `CREATED_BY` bigint(20) NOT NULL,
  `CREATION_DATE` date NOT NULL,
  `LAST_UPDATED_BY` bigint(20) NOT NULL,
  `LAST_UPDATE_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `PERIOD_ID` bigint(20) NOT NULL,
  `ALIAS_ID` bigint(20) NOT NULL,
  `ACTIVE_FLAG` varchar(1) NOT NULL,
  `ROWNO` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cxs_users`
--

CREATE TABLE IF NOT EXISTS `cxs_users` (
  `USER_ID` bigint(20) NOT NULL,
  `USER_NAME` varchar(40) DEFAULT NULL,
  `ENC_KEY` varchar(240) DEFAULT NULL,
  `TEMP_PASSWORD` varchar(1) NOT NULL DEFAULT 'N',
  `RESET_DAYS` bigint(20) DEFAULT NULL,
  `PSW_RESET_DATE` date NOT NULL,
  `RESOURCE_ID` bigint(20) NOT NULL,
  `ROLE_ID` int(11) NOT NULL,
  `ROLE_START_DATE` date NOT NULL,
  `ROLE_END_DATE` date NOT NULL,
  `PHOTO` varchar(255) DEFAULT NULL,
  `START_DATE` date NOT NULL,
  `END_DATE` date NOT NULL,
  `PWD_RULE_CODE` varchar(20) NOT NULL,
  `CREATION_DATE` datetime DEFAULT NULL,
  `LAST_UPDATE_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CREATED_BY` bigint(20) NOT NULL,
  `LAST_UPDATED_BY` bigint(20) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cxs_users`
--

INSERT INTO `cxs_users` (`USER_ID`, `USER_NAME`, `ENC_KEY`, `TEMP_PASSWORD`, `RESET_DAYS`, `PSW_RESET_DATE`, `RESOURCE_ID`, `ROLE_ID`, `ROLE_START_DATE`, `ROLE_END_DATE`, `PHOTO`, `START_DATE`, `END_DATE`, `PWD_RULE_CODE`, `CREATION_DATE`, `LAST_UPDATE_DATE`, `CREATED_BY`, `LAST_UPDATED_BY`) VALUES
(1, 'A@D', 'øÿÿÿÿÿÿÿÿ', 'N', 30, '2018-01-02', 7, 1, '0000-00-00', '0000-00-00', NULL, '2017-09-15', '0000-00-00', '', '2017-10-25 18:10:22', '2018-01-09 07:51:43', 2, 1),
(2, 'A@T.COM', 'øøøøøøÿÿ', 'N', 30, '2018-01-01', 5, 2, '0000-00-00', '0000-00-00', NULL, '2017-09-28', '0000-00-00', '', '2017-10-31 13:02:07', '2018-01-09 07:52:07', 2, 1),
(3, 'FF@W.COM', 'ª­ªª­­ªªª', 'N', 30, '2018-01-01', 12, 3, '0000-00-00', '0000-00-00', NULL, '2017-09-04', '0000-00-00', '', '2017-10-31 13:02:35', '2018-01-09 07:52:23', 2, 1),
(4, '', '', 'N', 0, '0000-00-00', 0, 4, '0000-00-00', '0000-00-00', NULL, '2017-01-01', '0000-00-00', '', '2017-11-02 10:53:09', '2018-01-02 12:49:09', 2, 2),
(5, 'T@AIL.COM', 'íüêíýýýý', 'N', 30, '0000-00-00', 10, 5, '0000-00-00', '0000-00-00', NULL, '2017-09-07', '0000-00-00', '', '2017-11-07 17:18:14', '2018-01-02 12:49:26', 2, 1),
(6, 'KALYAN77', NULL, 'N', NULL, '0000-00-00', 0, 6, '0000-00-00', '0000-00-00', NULL, '1970-01-01', '0000-00-00', '', '2017-12-04 16:26:53', '2018-01-02 12:49:30', 1, 1),
(7, 'ABC@WW.COM', '«¬«¬«¬«¬', 'N', 10, '0000-00-00', 2, 7, '0000-00-00', '0000-00-00', NULL, '2017-12-12', '0000-00-00', '', '2017-12-08 13:01:02', '2018-01-02 12:49:40', 2, 2),
(8, 'ABC2@WW.COM', '¨«ª­¬¯®¡', 'N', 10, '0000-00-00', 1, 5, '0000-00-00', '0000-00-00', NULL, '2017-12-10', '2017-12-14', '', '2017-12-08 13:06:10', '2018-01-02 12:49:43', 2, 2),
(9, 'A@B.COM', 'Öéíðö÷¨«ªº', 'N', 30, '0000-00-00', 3, 2, '0000-00-00', '0000-00-00', NULL, '2017-12-15', '2017-12-20', '', '2017-12-08 13:15:34', '2018-01-02 12:49:47', 2, 2),
(10, 'PQ@TT.COM', '¨«ª­¬¯®¡', 'N', 25, '0000-00-00', 4, 5, '0000-00-00', '0000-00-00', NULL, '2017-12-12', '0000-00-00', '', '2017-12-08 13:22:50', '2018-01-02 12:49:51', 2, 2),
(11, 'ABCD@TEST.COM', NULL, 'N', NULL, '0000-00-00', 0, 2, '0000-00-00', '0000-00-00', NULL, '2017-12-15', '2017-12-16', '', '2017-12-15 19:36:32', '2018-01-02 12:49:58', 1, 1),
(12, 'FNM@TEST.COM', NULL, 'N', NULL, '0000-00-00', 0, 5, '0000-00-00', '0000-00-00', NULL, '2017-12-22', '2017-12-27', '', '2017-12-15 19:42:39', '2018-01-02 12:50:04', 1, 1),
(13, 'FSNM@TEST.COM', NULL, 'N', NULL, '0000-00-00', 0, 4, '0000-00-00', '0000-00-00', NULL, '2017-12-21', '2017-12-22', '', '2017-12-15 19:51:00', '2018-01-02 12:50:07', 1, 1),
(14, 'ABCD@DFFDG', '«¬ºËé«¨««¨«', 'N', 30, '0000-00-00', 10, 2, '0000-00-00', '0000-00-00', NULL, '2017-12-18', '0000-00-00', '', '2017-12-19 14:35:48', '2018-01-02 12:50:10', 2, 2),
(15, 'AA@TEST', '«¬­®¡ýþ¼½º¬­É', 'N', 30, '0000-00-00', 1, 6, '0000-00-00', '0000-00-00', NULL, '2017-12-12', '0000-00-00', '', '2017-12-19 14:42:28', '2018-01-02 12:50:13', 2, 2),
(16, 'AA@Q.COM', '¨«¬½¼þÿýßÝÝ«¬¶³', 'N', 30, '0000-00-00', 6, 7, '0000-00-00', '0000-00-00', NULL, '2017-12-11', '0000-00-00', '', '2017-12-19 14:44:32', '2018-01-02 12:50:17', 2, 2),
(17, 'RAJU@A.COM', 'ËøóìÙ¨«ª­', 'N', 30, '0000-00-00', 1, 4, '0000-00-00', '0000-00-00', NULL, '2018-01-02', '2018-01-19', '', '2018-01-02 16:05:03', '2018-01-02 12:50:20', 2, 2),
(18, 'RA@B.COM', 'ËøóìÙ¨«ª­', 'N', 30, '0000-00-00', 1, 7, '0000-00-00', '0000-00-00', NULL, '2018-01-03', '2018-01-09', '', '2018-01-02 16:13:37', '2018-01-02 12:50:24', 2, 2),
(19, 'pranab.roy@webskitters.com', '¨«ª­¬¯®¡ ÙÎíê', 'N', 30, '2018-01-15', 1, 7, '2018-01-03', '0000-00-00', NULL, '2018-01-02', '0000-00-00', '', '2018-01-02 18:40:45', '2018-01-15 05:24:48', 2, 2),
(20, 'rbam@sample.com', '¨«ª­¬¯®¡ ÙÎíê', 'N', 30, '2018-01-09', 1, 7, '2018-01-02', '0000-00-00', 'rabit.jpeg', '2018-01-02', '0000-00-00', '', '2018-01-02 19:08:10', '2018-01-11 15:59:23', 2, 2),
(21, 'kalyan.dey@webskitters.com', '×øíðö÷øõ¨½', 'N', 30, '2018-01-10', 1, 5, '2018-01-02', '0000-00-00', NULL, '2018-01-05', '0000-00-00', '', '2018-01-03 11:36:47', '2018-01-10 04:25:43', 2, 2),
(22, 'ABC@WWWWW.COM', '¨«ª­¬¯®¡ ÙÎíê', 'N', 30, '2018-01-01', 1, 0, '1970-01-01', '0000-00-00', NULL, '2018-01-10', '0000-00-00', '', '2018-01-08 15:39:59', '2018-01-09 07:53:04', 20, 20),
(23, 'ABC@WWWWW.COM', '¨«ª­¬¯®¡ ÙÎíê', 'N', 30, '2018-01-01', 1, 0, '1970-01-01', '0000-00-00', NULL, '2018-01-10', '0000-00-00', '', '2018-01-08 15:41:02', '2018-01-09 07:53:20', 20, 20),
(24, 'QQQQ@WEB.OM', '¨«ª­¬¯®¡ ÙÎíê', 'N', 30, '2018-01-01', 1, 0, '1970-01-01', '0000-00-00', 'Affiliate-Marketing-Top-Section.jpg', '2018-01-09', '0000-00-00', '', '2018-01-08 15:42:01', '2018-01-09 07:53:34', 20, 20);

-- --------------------------------------------------------

--
-- Table structure for table `cxs_users_favorites`
--

CREATE TABLE IF NOT EXISTS `cxs_users_favorites` (
  `USER_ID` bigint(20) NOT NULL,
  `FEATURE_NAME` varchar(40) NOT NULL,
  `PAGE_NAME` varchar(40) NOT NULL,
  `LAST_UPDATE_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `MODULE_NAME` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cxs_users_favorites`
--

INSERT INTO `cxs_users_favorites` (`USER_ID`, `FEATURE_NAME`, `PAGE_NAME`, `LAST_UPDATE_DATE`, `MODULE_NAME`) VALUES
(1, 'Dashboard', 'index.php', '2017-09-23 09:03:07', 'Time Accounting'),
(1, 'Create WBS', 'workbreakdown-structure.php', '2017-12-14 12:50:07', 'Access Management');

-- --------------------------------------------------------

--
-- Table structure for table `cxs_wbs`
--

CREATE TABLE IF NOT EXISTS `cxs_wbs` (
  `WBS_ID` bigint(20) NOT NULL,
  `SEQUENCE` bigint(20) NOT NULL DEFAULT '0',
  `SEGMENT1` varchar(100) NOT NULL DEFAULT '',
  `SEGMENT2` varchar(100) NOT NULL DEFAULT '',
  `SEGMENT3` varchar(100) NOT NULL DEFAULT '',
  `SEGMENT4` varchar(100) NOT NULL DEFAULT '',
  `SEGMENT5` varchar(100) NOT NULL DEFAULT '',
  `SEGMENT6` varchar(100) NOT NULL DEFAULT '',
  `SEGMENT7` varchar(100) NOT NULL DEFAULT '',
  `SEGMENT8` varchar(100) NOT NULL DEFAULT '',
  `SEGMENT9` varchar(100) NOT NULL DEFAULT '',
  `SEGMENT10` varchar(100) NOT NULL DEFAULT '',
  `SEGMENT11` varchar(100) NOT NULL DEFAULT '',
  `SEGMENT12` varchar(100) NOT NULL DEFAULT '',
  `SEGMENT13` varchar(100) NOT NULL DEFAULT '',
  `SEGMENT14` varchar(100) NOT NULL DEFAULT '',
  `SEGMENT15` varchar(100) NOT NULL DEFAULT '',
  `DISPLAY_VALUE1` varchar(100) NOT NULL DEFAULT '',
  `DISPLAY_VALUE2` varchar(100) NOT NULL DEFAULT '',
  `DISPLAY_VALUE3` varchar(100) NOT NULL DEFAULT '',
  `DISPLAY_VALUE4` varchar(100) NOT NULL DEFAULT '',
  `DISPLAY_VALUE5` varchar(100) NOT NULL DEFAULT '',
  `DISPLAY_VALUE6` varchar(100) NOT NULL DEFAULT '',
  `DISPLAY_VALUE7` varchar(100) NOT NULL DEFAULT '',
  `DISPLAY_VALUE8` varchar(100) NOT NULL DEFAULT '',
  `DISPLAY_VALUE9` varchar(100) NOT NULL DEFAULT '',
  `DISPLAY_VALUE10` varchar(100) NOT NULL DEFAULT '',
  `DISPLAY_VALUE11` varchar(100) NOT NULL DEFAULT '',
  `DISPLAY_VALUE12` varchar(100) NOT NULL DEFAULT '',
  `DISPLAY_VALUE13` varchar(100) NOT NULL DEFAULT '',
  `DISPLAY_VALUE14` varchar(100) NOT NULL DEFAULT '',
  `DISPLAY_VALUE15` varchar(100) NOT NULL DEFAULT '',
  `DESCRIPTION1` varchar(100) NOT NULL DEFAULT '',
  `DESCRIPTION2` varchar(100) NOT NULL DEFAULT '',
  `DESCRIPTION3` varchar(100) NOT NULL DEFAULT '',
  `DESCRIPTION4` varchar(100) NOT NULL DEFAULT '',
  `DESCRIPTION5` varchar(100) NOT NULL DEFAULT '',
  `DESCRIPTION6` varchar(100) NOT NULL DEFAULT '',
  `DESCRIPTION7` varchar(100) NOT NULL DEFAULT '',
  `DESCRIPTION8` varchar(100) NOT NULL DEFAULT '',
  `DESCRIPTION9` varchar(100) NOT NULL DEFAULT '',
  `DESCRIPTION10` varchar(100) NOT NULL DEFAULT '',
  `DESCRIPTION11` varchar(100) NOT NULL DEFAULT '',
  `DESCRIPTION12` varchar(100) NOT NULL DEFAULT '',
  `DESCRIPTION13` varchar(100) NOT NULL DEFAULT '',
  `DESCRIPTION14` varchar(100) NOT NULL DEFAULT '',
  `DESCRIPTION15` varchar(100) NOT NULL DEFAULT '',
  `ROLLUP1` varchar(100) NOT NULL DEFAULT '',
  `ROLLUP2` varchar(100) NOT NULL DEFAULT '',
  `ROLLUP3` varchar(100) NOT NULL DEFAULT '',
  `ROLLUP4` varchar(100) NOT NULL DEFAULT '',
  `ROLLUP5` varchar(100) NOT NULL DEFAULT '',
  `ROLLUP6` varchar(100) NOT NULL DEFAULT '',
  `ROLLUP7` varchar(100) NOT NULL DEFAULT '',
  `ROLLUP8` varchar(100) NOT NULL DEFAULT '',
  `ROLLUP9` varchar(100) NOT NULL DEFAULT '',
  `ROLLUP10` varchar(100) NOT NULL DEFAULT '',
  `ROLLUP11` varchar(100) NOT NULL DEFAULT '',
  `ROLLUP12` varchar(100) NOT NULL DEFAULT '',
  `ROLLUP13` varchar(100) NOT NULL DEFAULT '',
  `ROLLUP14` varchar(100) NOT NULL DEFAULT '',
  `ROLLUP15` varchar(100) NOT NULL DEFAULT '',
  `ACTIVE_FLAG1` varchar(100) NOT NULL DEFAULT '',
  `ACTIVE_FLAG2` varchar(100) NOT NULL DEFAULT '',
  `ACTIVE_FLAG3` varchar(100) NOT NULL DEFAULT '',
  `ACTIVE_FLAG4` varchar(100) NOT NULL DEFAULT '',
  `ACTIVE_FLAG5` varchar(100) NOT NULL DEFAULT '',
  `ACTIVE_FLAG6` varchar(100) NOT NULL DEFAULT '',
  `ACTIVE_FLAG7` varchar(100) NOT NULL DEFAULT '',
  `ACTIVE_FLAG8` varchar(100) NOT NULL DEFAULT '',
  `ACTIVE_FLAG9` varchar(100) NOT NULL DEFAULT '',
  `ACTIVE_FLAG10` varchar(100) NOT NULL DEFAULT '',
  `ACTIVE_FLAG11` varchar(100) NOT NULL DEFAULT '',
  `ACTIVE_FLAG12` varchar(100) NOT NULL DEFAULT '',
  `ACTIVE_FLAG13` varchar(100) NOT NULL DEFAULT '',
  `ACTIVE_FLAG14` varchar(100) NOT NULL DEFAULT '',
  `ACTIVE_FLAG15` varchar(100) NOT NULL DEFAULT '',
  `IN_USE1` varchar(100) NOT NULL DEFAULT '',
  `IN_USE2` varchar(100) NOT NULL DEFAULT '',
  `IN_USE3` varchar(100) NOT NULL DEFAULT '',
  `IN_USE4` varchar(100) NOT NULL DEFAULT '',
  `IN_USE5` varchar(100) NOT NULL DEFAULT '',
  `IN_USE6` varchar(100) NOT NULL DEFAULT '',
  `IN_USE7` varchar(100) NOT NULL DEFAULT '',
  `IN_USE8` varchar(100) NOT NULL DEFAULT '',
  `IN_USE9` varchar(100) NOT NULL DEFAULT '',
  `IN_USE10` varchar(100) NOT NULL DEFAULT '',
  `IN_USE11` varchar(100) NOT NULL DEFAULT '',
  `IN_USE12` varchar(100) NOT NULL DEFAULT '',
  `IN_USE13` varchar(100) NOT NULL DEFAULT '',
  `IN_USE14` varchar(100) NOT NULL DEFAULT '',
  `IN_USE15` varchar(100) NOT NULL DEFAULT '',
  `CREATED_BY` bigint(20) NOT NULL,
  `CREATION_DATE` date NOT NULL,
  `LAST_UPDATED_BY` bigint(20) NOT NULL,
  `LAST_UPDATE_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=353 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cxs_wbs`
--

INSERT INTO `cxs_wbs` (`WBS_ID`, `SEQUENCE`, `SEGMENT1`, `SEGMENT2`, `SEGMENT3`, `SEGMENT4`, `SEGMENT5`, `SEGMENT6`, `SEGMENT7`, `SEGMENT8`, `SEGMENT9`, `SEGMENT10`, `SEGMENT11`, `SEGMENT12`, `SEGMENT13`, `SEGMENT14`, `SEGMENT15`, `DISPLAY_VALUE1`, `DISPLAY_VALUE2`, `DISPLAY_VALUE3`, `DISPLAY_VALUE4`, `DISPLAY_VALUE5`, `DISPLAY_VALUE6`, `DISPLAY_VALUE7`, `DISPLAY_VALUE8`, `DISPLAY_VALUE9`, `DISPLAY_VALUE10`, `DISPLAY_VALUE11`, `DISPLAY_VALUE12`, `DISPLAY_VALUE13`, `DISPLAY_VALUE14`, `DISPLAY_VALUE15`, `DESCRIPTION1`, `DESCRIPTION2`, `DESCRIPTION3`, `DESCRIPTION4`, `DESCRIPTION5`, `DESCRIPTION6`, `DESCRIPTION7`, `DESCRIPTION8`, `DESCRIPTION9`, `DESCRIPTION10`, `DESCRIPTION11`, `DESCRIPTION12`, `DESCRIPTION13`, `DESCRIPTION14`, `DESCRIPTION15`, `ROLLUP1`, `ROLLUP2`, `ROLLUP3`, `ROLLUP4`, `ROLLUP5`, `ROLLUP6`, `ROLLUP7`, `ROLLUP8`, `ROLLUP9`, `ROLLUP10`, `ROLLUP11`, `ROLLUP12`, `ROLLUP13`, `ROLLUP14`, `ROLLUP15`, `ACTIVE_FLAG1`, `ACTIVE_FLAG2`, `ACTIVE_FLAG3`, `ACTIVE_FLAG4`, `ACTIVE_FLAG5`, `ACTIVE_FLAG6`, `ACTIVE_FLAG7`, `ACTIVE_FLAG8`, `ACTIVE_FLAG9`, `ACTIVE_FLAG10`, `ACTIVE_FLAG11`, `ACTIVE_FLAG12`, `ACTIVE_FLAG13`, `ACTIVE_FLAG14`, `ACTIVE_FLAG15`, `IN_USE1`, `IN_USE2`, `IN_USE3`, `IN_USE4`, `IN_USE5`, `IN_USE6`, `IN_USE7`, `IN_USE8`, `IN_USE9`, `IN_USE10`, `IN_USE11`, `IN_USE12`, `IN_USE13`, `IN_USE14`, `IN_USE15`, `CREATED_BY`, `CREATION_DATE`, `LAST_UPDATED_BY`, `LAST_UPDATE_DATE`) VALUES
(1, 1, 'Capital Finance', 'Department of Insuarance', 'Financial Devision', 'Receivation Devision', 'Department of Insuarance', 'Capital Finance', 'Department of Insuarance', 'Capital Finance', 'Financial Devision', 'Department of Insuarance', 'Financial Devision', 'Financial Devision', 'Financial Devision', 'Department of Insuarance', 'Financial Devision', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '2017-11-23', 0, '2017-12-11 07:40:52'),
(2, 1, 's1', 'ss2', 'ss3', 'ss4', 'ss5', 'ss6', 'ss7', 'ss8', 'ss9', 'ss10', 'ss11', 'ss12', 'ss13', 'ss14', 'ss15', 'd1', 'display2', 'display3', 'display4', 'display5', 'display6', 'display7', 'display8', 'display9', 'display10', 'display11', 'display12', 'display13', 'display14', 'display15', 'descp 1', 'descp 2', 'descp 3', 'descp 4', 'descp 5', 'descp 6', 'descp 7', 'descp 8', 'descp 9', 'descp 10', 'descp 11', 'descp 12', 'descp 13', 'descp 14', 'descp 15', '', '', '', 'y', '', '', 'Y', '', '', '', 'Y', '', '', '', '', '', 'Y', '', '', '', '', '', 'Y', '', '', '', '', '', 'Y', '', '', '', 'Y', '', '', 'Y', 'Y', '', '', '', '', '', '', '', '', 0, '0000-00-00', 0, '2017-11-16 09:40:21'),
(3, 1, 's1', 's2', 's3', 's4', '', '', '', '', 's9', 's10', 's11', 's12', 's13', 's14', 's15', 'd1', 'd2', 'd3', 'd4', 'd5', 'd6', 'd7', 'd8', 'd9', 'd10', 'd11', 'd12', 'd13', 'd14', 'd15', 'descp 1', 'descp 2', 'descp 3', 'descp 4', 'descp 5', 'descp 6', 'descp 7', 'descp 8', 'descp 9', 'descp 10', 'descp 11', 'descp 12', 'descp 13', 'descp 14', 'descp 15', '', '', '', 'y', '', '', 'Y', '', '', '', 'Y', '', '', '', '', '', 'Y', '', '', '', '', '', 'Y', '', '', '', '', '', 'Y', '', '', '', 'Y', '', '', 'Y', 'Y', '', '', '', '', '', '', '', '', 0, '0000-00-00', 0, '2017-11-17 07:02:34'),
(4, 0, 's1', 's2', 's3', 's4', 's5', 's6', 's7', 's8', 's9', 's10', 's11', 's12', 's13', 's14', 's15', 'd1', 'd2', 'd3', 'd4', 'd5', 'd6', 'd7', 'd8', 'd9', 'd10', 'd11', 'd12', 'd13', 'd14', 'd15', 'descp 1', 'descp 2', 'descp 3', 'descp 4', 'descp 5', 'descp 6', 'descp 7', 'descp 8', 'descp 9', 'descp 10', 'descp 11', 'descp 12', 'descp 13', 'descp 14', 'descp 15', '', '', '', 'y', '', '', 'Y', '', '', '', 'Y', '', '', '', '', '', 'Y', '', '', '', '', '', 'Y', '', '', '', '', '', 'Y', '', '', '', 'Y', '', '', 'Y', 'Y', '', '', '', '', '', '', '', '', 0, '0000-00-00', 0, '2017-11-16 10:09:06'),
(5, 0, 's1', 's2', 's3', 's4', 's5', 's6', 's7', 's8', 's9', 's10', 's11', 's12', 's13', 's14', 's15', 'd1', 'd2', 'd3', 'd4', 'd5', 'd6', 'd7', 'd8', 'd9', 'd10', 'd11', 'd12', 'd13', 'd14', 'd15', 'descp 1', 'descp 2', 'descp 3', 'descp 4', 'descp 5', 'descp 6', 'descp 7', 'descp 8', 'descp 9', 'descp 10', 'descp 11', 'descp 12', 'descp 13', 'descp 14', 'descp 15', '', '', '', 'y', '', '', 'Y', '', '', '', 'Y', '', '', '', '', '', 'Y', '', '', '', '', '', 'Y', '', '', '', '', '', 'Y', '', '', '', 'Y', '', '', 'Y', 'Y', '', '', '', '', '', '', '', '', 0, '0000-00-00', 0, '2017-11-16 10:09:13'),
(6, 0, 's1', 'Capital Finance', 's3', 's4', 'Department of Insuarance', 's6', 's7', 's8', 's9', 's10', 's11', 's12', 's13', 's14', 's15', 'd1', 'd2', 'd3', 'd4', 'd5', 'd6', 'd7', 'd8', 'd9', 'd10', 'd11', 'd12', 'd13', 'd14', 'd15', 'descp 1', 'descp 2', 'descp 3', 'descp 4', 'descp 5', 'descp 6', 'descp 7', 'descp 8', 'descp 9', 'descp 10', 'descp 11', 'descp 12', 'descp 13', 'descp 14', 'descp 15', 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'Y', 'N', 'N', 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 0, '0000-00-00', 0, '2017-12-14 13:33:02'),
(7, 0, 's1', 's2', 's3', 's4', 's5', 's6', 's7', 's8', 's9', 's10', 's11', 's12', 's13', 's14', 's15', 'd1', 'd2', 'd3', 'd4', 'd5', 'd6', 'd7', 'd8', 'd9', 'd10', 'd11', 'd12', 'd13', 'd14', 'd15', 'descp 1', 'descp 2', 'descp 3', 'descp 4', 'descp 5', 'descp 6', 'descp 7', 'descp 8', 'descp 9', 'descp 10', 'descp 11', 'descp 12', 'descp 13', 'descp 14', 'descp 15', '', '', '', 'y', '', '', 'Y', '', '', '', 'Y', '', '', '', '', '', 'Y', '', '', '', '', '', 'Y', '', '', '', '', '', 'Y', '', '', '', 'Y', '', '', 'Y', 'Y', '', '', '', '', '', '', '', '', 0, '0000-00-00', 0, '2017-11-16 10:09:15'),
(8, 0, 's1', 's2', 's3', 's4', 's5', 's6', 's7', 's8', 's9', 's10', 's11', 's12', 's13', 's14', 's15', 'd1', 'd2', 'd3', 'd4', 'd5', 'd6', 'd7', 'd8', 'd9', 'd10', 'd11', 'd12', 'd13', 'd14', 'd15', 'descp 1', 'descp 2', 'descp 3', 'descp 4', 'descp 5', 'descp 6', 'descp 7', 'descp 8', 'descp 9', 'descp 10', 'descp 11', 'descp 12', 'descp 13', 'descp 14', 'descp 15', 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'Y', 'N', 'N', 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 0, '0000-00-00', 0, '2017-12-14 13:32:08'),
(9, 0, 's1', 's2', 's3', 's4', 's5', 's6', 's7', 's8', 's9', 's10', 's11', 's12', 's13', 's14', 's15', 'd1', 'd2', 'd3', 'd4', 'd5', 'd6', 'd7', 'd8', 'd9', 'd10', 'd11', 'd12', 'd13', 'd14', 'd15', 'descp 1', 'descp 2', 'descp 3', 'descp 4', 'descp 5', 'descp 6', 'descp 7', 'descp 8', 'descp 9', 'descp 10', 'descp 11', 'descp 12', 'descp 13', 'descp 14', 'descp 15', 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'Y', 'N', 'N', 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 0, '0000-00-00', 0, '2017-12-13 15:17:30'),
(350, 0, 'Seg 11', 'Seg 22', 'Seg 33', 'Seg 44', 'Seg 11', 'Seg 66', 'Seg 11', 'Seg 11', 'Seg 11', 'Seg 11', 'Seg 11', 'Seg 11', 'Seg 11', 'Seg 11', 'Seg 11', 'Dis 11', 'Dis 22', 'Dis 33', 'Dis 44', 'Dis 55', 'Dis 66', 'Dis 77', 'Dis 88', 'Dis 99', 'Dis 100', 'Dis 111', 'Dis 222', 'Dis 333', 'Dis 444', 'Dis 555', 'Lorem Ipsum', 'Lorem Ipsum', 'Lorem Ipsum', 'Lorem Ipsum', 'Lorem Ipsum', 'Lorem Ipsum', 'Lorem Ipsum', 'Lorem Ipsum', 'Lorem Ipsum', 'Lorem Ipsum', 'Lorem Ipsum', 'Lorem Ipsum', 'Lorem Ipsum', 'Lorem Ipsum', 'Lorem Ipsum', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 0, '2017-12-14', 0, '2017-12-14 13:16:17'),
(351, 0, 'N1', 'N1', 'N1', 'N1', 'N5', 'N1', 'N1', 'N1', 'N1', 'N10', 'N1', 'N1', 'N1', 'N1', 'N15', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'N1', 'Y', 'N', 'N', 'N', 'Y', 'N', 'N', 'N', 'Y', 'Y', 'N', 'N', 'Y', 'N', 'Y', 'N', 'Y', 'N', 'Y', 'N', 'Y', 'N', 'Y', 'N', 'Y', 'N', 'Y', 'N', 'Y', 'Y', 'N', 'N', 'Y', 'N', 'N', 'N', 'Y', 'N', 'N', 'Y', 'Y', 'N', 'N', 'N', 'Y', 0, '2017-12-14', 0, '2017-12-14 13:17:56'),
(352, 0, 'WBS1', 'WBS1', 'WBS1', 'WBS1', 'WBS1', 'WBS1', 'WBS7', 'WBS8', 'WBS9', 'WBS10', 'WBS11', 'WBS12', 'WBS13', 'WBS14', 'WBS15', 'WBSDP1', 'WBSDP1', 'WBSDP1', 'WBSDP1', 'WBSDP1', 'WBSDP1', 'WBSDP7', 'WBSDP8', 'WBSDP9', 'WBSDP10', 'WBSDP11', 'WBSDP12', 'WBSDP13', 'WBSDP14', 'WBSDP15', 'WBSDCN1', 'WBSDCN1', 'WBSDCN1', 'WBSDCN1', 'WBSDCN1', 'WBSDCN1', 'WBSDCN7', 'WBSDCN8', 'WBSDCN9', 'WBSDCN10', 'WBSDCN11', 'WBSDCN12', 'WBSDCN13', 'WBSDCN14', 'WBSDCN15', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 0, '2017-12-14', 0, '2017-12-14 13:36:16');

-- --------------------------------------------------------

--
-- Table structure for table `cxs_workshifts`
--

CREATE TABLE IF NOT EXISTS `cxs_workshifts` (
  `WORKSHIFT_ID` bigint(20) NOT NULL,
  `NAME` varchar(100) NOT NULL DEFAULT '',
  `DESCRIPTION` varchar(240) NOT NULL DEFAULT '',
  `IN_USE_FLAG` varchar(1) NOT NULL DEFAULT '',
  `ACTIVE_FLAG` varchar(1) NOT NULL DEFAULT '',
  `OVERTIME_ALLOWED` varchar(1) NOT NULL DEFAULT '',
  `SPLIT_SHIFT_ALLOWED` varchar(1) NOT NULL DEFAULT '',
  `WORKSHIFT_TYPE` varchar(40) NOT NULL DEFAULT '',
  `LAST_SESSION_ID` varchar(240) NOT NULL DEFAULT '',
  `CREATED_BY` bigint(20) NOT NULL,
  `CREATION_DATE` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` bigint(10) NOT NULL,
  `LAST_UPDATED` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `TIMEZONE` varchar(240) NOT NULL DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cxs_workshifts`
--

INSERT INTO `cxs_workshifts` (`WORKSHIFT_ID`, `NAME`, `DESCRIPTION`, `IN_USE_FLAG`, `ACTIVE_FLAG`, `OVERTIME_ALLOWED`, `SPLIT_SHIFT_ALLOWED`, `WORKSHIFT_TYPE`, `LAST_SESSION_ID`, `CREATED_BY`, `CREATION_DATE`, `LAST_UPDATED_BY`, `LAST_UPDATED`, `TIMEZONE`) VALUES
(1, 'aa', '', '', '', '', '', '', '', 1, '2017-10-30 12:15:15', 1, '2017-10-30 06:45:15', ''),
(2, 'test', 'test descr', '', '', '', '', '', '', 1, '2017-10-30 12:35:44', 1, '2017-10-30 07:05:44', 'AKDT'),
(3, 'testttt', 'testt111', '', '', '', '', '', '', 1, '2017-10-30 12:36:20', 1, '2017-10-30 07:06:20', 'CDT'),
(4, 'aa', 'vv', '', '', '', '', 'Part Time Shift', '', 1, '2017-10-30 12:36:47', 1, '2017-10-30 07:06:47', 'CDT'),
(5, 'A', 'B', 'Y', 'Y', 'Y', 'Y', 'Flexible Shift', '', 1, '2017-10-30 12:47:23', 1, '2017-10-30 07:17:23', 'AKDT'),
(6, 'AA', 'AD', 'N', 'Y', 'Y', 'Y', 'Part Time Shift', '', 1, '2017-10-30 12:51:06', 1, '2017-10-30 07:21:06', 'PDT'),
(7, 'a', 'd', 'N', 'N', 'N', 'N', '', '', 1, '2017-10-30 13:10:41', 1, '2017-10-30 07:40:41', 'PDT'),
(8, 'aa', 'aa', 'N', 'N', 'N', 'N', '', '', 1, '2017-10-30 13:22:31', 1, '2017-10-30 07:52:31', 'AKDT');

-- --------------------------------------------------------

--
-- Table structure for table `cxs_workshifts_detail`
--

CREATE TABLE IF NOT EXISTS `cxs_workshifts_detail` (
  `WORKSHIFT_ID` bigint(20) NOT NULL DEFAULT '0',
  `SHIFT_NAME` varchar(40) NOT NULL DEFAULT '',
  `SHIFT_CODE` varchar(10) NOT NULL DEFAULT '',
  `WORKDAY_TYPE` varchar(40) NOT NULL DEFAULT '',
  `DAILY_WORK_HOURS` bigint(20) NOT NULL DEFAULT '0',
  `ALLOW_OVERTIME_FLAG` varchar(1) NOT NULL DEFAULT '',
  `EFFECTIVE_START_DATE` date DEFAULT NULL,
  `EFFECTIVE_END_DATE` date DEFAULT NULL,
  `TIMEZONE` date DEFAULT NULL,
  `BEGIN_WORKDAY` varchar(40) NOT NULL DEFAULT '',
  `END_WORKDAY` varchar(40) NOT NULL DEFAULT '',
  `BEGIN_TIME` datetime DEFAULT NULL,
  `END_TIME` datetime DEFAULT NULL,
  `ROTATING_SHIFT_FLAG` varchar(1) NOT NULL DEFAULT '',
  `LAST_SESSION_ID` varchar(240) NOT NULL DEFAULT '',
  `CREATED_BY` bigint(20) NOT NULL,
  `CREATION_DATE` datetime DEFAULT NULL,
  `LAST_UPDATED_BY` bigint(10) NOT NULL,
  `LAST_UPDATED` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sys_applications`
--

CREATE TABLE IF NOT EXISTS `sys_applications` (
  `APPLICATION_ID` bigint(20) NOT NULL,
  `NAME` varchar(240) NOT NULL,
  `DESCRIPTION` varchar(240) NOT NULL,
  `DATE_ENABLED` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sys_applications`
--

INSERT INTO `sys_applications` (`APPLICATION_ID`, `NAME`, `DESCRIPTION`, `DATE_ENABLED`) VALUES
(1, 'RBAM', '', '0000-00-00'),
(2, 'Time Accounting Rules', '', '0000-00-00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cxs_aliases`
--
ALTER TABLE `cxs_aliases`
  ADD PRIMARY KEY (`ALIAS_ID`),
  ADD KEY `WBS_ID` (`WBS_ID`);

--
-- Indexes for table `cxs_am_approval_mgmt`
--
ALTER TABLE `cxs_am_approval_mgmt`
  ADD KEY `USER_ID` (`USER_ID`),
  ADD KEY `REFERENCE_APPROVER_ID` (`REFERENCE_APPROVER_ID`);

--
-- Indexes for table `cxs_am_app_admin`
--
ALTER TABLE `cxs_am_app_admin`
  ADD PRIMARY KEY (`APP_ADM_ID`),
  ADD KEY `USER_ID` (`USER_ID`);

--
-- Indexes for table `cxs_am_personal_alias`
--
ALTER TABLE `cxs_am_personal_alias`
  ADD KEY `USER_ID` (`USER_ID`);

--
-- Indexes for table `cxs_am_roles`
--
ALTER TABLE `cxs_am_roles`
  ADD PRIMARY KEY (`ROLE_ID`);

--
-- Indexes for table `cxs_am_ta_rules`
--
ALTER TABLE `cxs_am_ta_rules`
  ADD KEY `USER_ID` (`USER_ID`);

--
-- Indexes for table `cxs_am_user_admin`
--
ALTER TABLE `cxs_am_user_admin`
  ADD KEY `USER_ID` (`USER_ID`),
  ADD KEY `TEMPORARY_APPROVER_ID` (`TEMPORARY_APPROVER_ID`);

--
-- Indexes for table `cxs_application_assignments`
--
ALTER TABLE `cxs_application_assignments`
  ADD PRIMARY KEY (`ASSIGNMENT_ID`),
  ADD KEY `USER_ID` (`USER_ID`),
  ADD KEY `CXS_APPLICATION_ASSIGNMENTS_U1` (`ASSIGNMENT_ID`),
  ADD KEY `APPLICATION_ROLE_ID` (`APPLICATION_ROLE_ID`);

--
-- Indexes for table `cxs_application_roles`
--
ALTER TABLE `cxs_application_roles`
  ADD PRIMARY KEY (`APPLICATION_ROLE_ID`);

--
-- Indexes for table `cxs_common_words`
--
ALTER TABLE `cxs_common_words`
  ADD PRIMARY KEY (`COMMON_WORD_ID`);

--
-- Indexes for table `cxs_holiday_calendar`
--
ALTER TABLE `cxs_holiday_calendar`
  ADD PRIMARY KEY (`HOLIDAY_CALENDAR_ID`);

--
-- Indexes for table `cxs_periods`
--
ALTER TABLE `cxs_periods`
  ADD PRIMARY KEY (`PERIOD_ID`),
  ADD KEY `ENTITY_ID` (`ENTITY_ID`);

--
-- Indexes for table `cxs_policy_header`
--
ALTER TABLE `cxs_policy_header`
  ADD PRIMARY KEY (`POLICY_ID`);

--
-- Indexes for table `cxs_preapp_rules`
--
ALTER TABLE `cxs_preapp_rules`
  ADD PRIMARY KEY (`PREAPP_RULE_ID`),
  ADD KEY `PERIOD_ID` (`PERIOD_ID`),
  ADD KEY `PROJECT_ID` (`PROJECT_ID`),
  ADD KEY `WBS_COMBINATION_ID` (`WBS_COMBINATION_ID`);

--
-- Indexes for table `cxs_resources`
--
ALTER TABLE `cxs_resources`
  ADD PRIMARY KEY (`RESOURCE_ID`),
  ADD KEY `RESOURCE_GROUP_ID` (`RESOURCE_GROUP_ID`);

--
-- Indexes for table `cxs_resource_address`
--
ALTER TABLE `cxs_resource_address`
  ADD PRIMARY KEY (`ADDRESS_RESOURCE_ID`),
  ADD KEY `RESOURCE_ID` (`RESOURCE_ID`);

--
-- Indexes for table `cxs_resource_contact`
--
ALTER TABLE `cxs_resource_contact`
  ADD PRIMARY KEY (`CONTACT_RESOURCE_ID`),
  ADD KEY `RESOURCE_ID` (`RESOURCE_ID`);

--
-- Indexes for table `cxs_resource_groups`
--
ALTER TABLE `cxs_resource_groups`
  ADD PRIMARY KEY (`RESOURCE_GROUP_ID`);

--
-- Indexes for table `cxs_site_settings`
--
ALTER TABLE `cxs_site_settings`
  ADD PRIMARY KEY (`SITE_SETTINGS_ID`);

--
-- Indexes for table `cxs_subscribers`
--
ALTER TABLE `cxs_subscribers`
  ADD PRIMARY KEY (`SUBSCRIBER_ID`),
  ADD KEY `USER_ID` (`USER_ID`);

--
-- Indexes for table `cxs_ta_modules`
--
ALTER TABLE `cxs_ta_modules`
  ADD KEY `USER_ID` (`USER_ID`);

--
-- Indexes for table `cxs_temp_approver`
--
ALTER TABLE `cxs_temp_approver`
  ADD KEY `USER_ID` (`USER_ID`),
  ADD KEY `PERIOD_ID` (`PERIOD_ID`);

--
-- Indexes for table `cxs_users`
--
ALTER TABLE `cxs_users`
  ADD PRIMARY KEY (`USER_ID`,`RESOURCE_ID`),
  ADD KEY `CXS_USERS_U1` (`USER_ID`);

--
-- Indexes for table `cxs_users_favorites`
--
ALTER TABLE `cxs_users_favorites`
  ADD KEY `USER_ID` (`USER_ID`);

--
-- Indexes for table `cxs_wbs`
--
ALTER TABLE `cxs_wbs`
  ADD PRIMARY KEY (`WBS_ID`);

--
-- Indexes for table `cxs_workshifts`
--
ALTER TABLE `cxs_workshifts`
  ADD PRIMARY KEY (`WORKSHIFT_ID`);

--
-- Indexes for table `cxs_workshifts_detail`
--
ALTER TABLE `cxs_workshifts_detail`
  ADD KEY `WORKSHIFT_ID` (`WORKSHIFT_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cxs_aliases`
--
ALTER TABLE `cxs_aliases`
  MODIFY `ALIAS_ID` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `cxs_am_app_admin`
--
ALTER TABLE `cxs_am_app_admin`
  MODIFY `APP_ADM_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cxs_am_roles`
--
ALTER TABLE `cxs_am_roles`
  MODIFY `ROLE_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `cxs_application_assignments`
--
ALTER TABLE `cxs_application_assignments`
  MODIFY `ASSIGNMENT_ID` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `cxs_application_roles`
--
ALTER TABLE `cxs_application_roles`
  MODIFY `APPLICATION_ROLE_ID` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `cxs_common_words`
--
ALTER TABLE `cxs_common_words`
  MODIFY `COMMON_WORD_ID` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `cxs_holiday_calendar`
--
ALTER TABLE `cxs_holiday_calendar`
  MODIFY `HOLIDAY_CALENDAR_ID` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `cxs_periods`
--
ALTER TABLE `cxs_periods`
  MODIFY `PERIOD_ID` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `cxs_policy_header`
--
ALTER TABLE `cxs_policy_header`
  MODIFY `POLICY_ID` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cxs_preapp_rules`
--
ALTER TABLE `cxs_preapp_rules`
  MODIFY `PREAPP_RULE_ID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cxs_resources`
--
ALTER TABLE `cxs_resources`
  MODIFY `RESOURCE_ID` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `cxs_resource_address`
--
ALTER TABLE `cxs_resource_address`
  MODIFY `ADDRESS_RESOURCE_ID` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `cxs_resource_contact`
--
ALTER TABLE `cxs_resource_contact`
  MODIFY `CONTACT_RESOURCE_ID` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `cxs_resource_groups`
--
ALTER TABLE `cxs_resource_groups`
  MODIFY `RESOURCE_GROUP_ID` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `cxs_site_settings`
--
ALTER TABLE `cxs_site_settings`
  MODIFY `SITE_SETTINGS_ID` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cxs_subscribers`
--
ALTER TABLE `cxs_subscribers`
  MODIFY `SUBSCRIBER_ID` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `cxs_users`
--
ALTER TABLE `cxs_users`
  MODIFY `USER_ID` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `cxs_wbs`
--
ALTER TABLE `cxs_wbs`
  MODIFY `WBS_ID` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=353;
--
-- AUTO_INCREMENT for table `cxs_workshifts`
--
ALTER TABLE `cxs_workshifts`
  MODIFY `WORKSHIFT_ID` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
