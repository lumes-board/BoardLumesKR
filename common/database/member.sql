--
-- 테이블 구조 `member`
--

CREATE TABLE `member` (
  `idx` int(20) NOT NULL,
  `id` varchar(30) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `exp` double NOT NULL DEFAULT 1000,
  `expTransactionQty` double NOT NULL DEFAULT 0,
  `guestbookQty` int(20) NOT NULL DEFAULT 0,
  `role` varchar(30) NOT NULL DEFAULT 'user',
  `lastLoginTime` datetime DEFAULT NULL,
  `lastLoginIP` varchar(40) DEFAULT NULL,
  `registrationTime` datetime NOT NULL,
  `registrationIP` varchar(40) NOT NULL,
  `registrationHash` varchar(100) DEFAULT NULL,
  `isActivated` varchar(10) NOT NULL DEFAULT 'FALSE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 인덱스 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`idx`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `member`
--
ALTER TABLE `member`
  MODIFY `idx` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
COMMIT;