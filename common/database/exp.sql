--
-- 테이블 구조 `exp`
--

CREATE TABLE `exp` (
  `idx` int(11) NOT NULL,
  `id` varchar(40) NOT NULL,
  `registrationExp` int(30) NOT NULL DEFAULT 0,
  `loginExp` int(30) NOT NULL DEFAULT 0,
  `boardExp` int(30) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 인덱스 `exp`
--
ALTER TABLE `exp`
  ADD PRIMARY KEY (`idx`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `exp`
--
ALTER TABLE `exp`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;