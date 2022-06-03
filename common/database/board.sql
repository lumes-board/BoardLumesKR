--
-- 테이블 구조 `board`
--

CREATE TABLE `board` (
  `idx` int(30) NOT NULL,
  `id` varchar(30) DEFAULT NULL,
  `message` varchar(1500) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `ip` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 인덱스 `board`
--
ALTER TABLE `board`
  ADD PRIMARY KEY (`idx`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `board`
--
ALTER TABLE `board`
  MODIFY `idx` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
COMMIT;