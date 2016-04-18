CREATE TABLE `c2_coupon_test` (
  `user_id` varchar(25) NOT NULL default '',
  `user_name` varchar(50) NOT NULL default '',
  `tel` varchar(30) NOT NULL default '',
  `coupon_id` varchar(25) NOT NULL default '',
  `coupon_name` varchar(255) NOT NULL default '',
  `coupon_type` varchar(10) NOT NULL default '',
  `redeem_time` varchar(20) NOT NULL  default '',
  `store_name` varchar(255) NOT NULL  default '',
  `staff_id` varchar(255) NOT NULL default '',
  `staff_name` varchar(255) NOT NULL default '',
  `isDeleted` varchar(1) NOT NULL default ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
