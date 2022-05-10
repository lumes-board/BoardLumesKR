<p align = "center">
 <img src="https://img.shields.io/github/languages/code-size/lumes-board/BoardLumesKR">
 <img src="https://img.shields.io/tokei/lines/github/lumes-board/BoardLumesKR">
 <img src="https://img.shields.io/github/languages/top/lumes-board/BoardLumesKR">
 <img src="https://img.shields.io/website?down_color=lightgray&down_message=offline&up_color=blue&up_message=online&url=http%3A%2F%2Fboard.lumes.kr">
</p>

# BoardLumesKR
**망가져버린 login.lumes.kr 다시 만들기**   

`"아아... login.lumes.kr이 비록 취약점과 엉망진창 코드로 인해 박살났지만 그래도 다시 더 멋지게 만들고 싶다..."`   
이전 프로젝트 : https://github.com/x3onkait/LoginLumesKR  

현재 이 프로젝트는 웹 서버에 호스팅 되어 있으며, <a href="http://board.lumes.kr/">`board.lumes.kr`</a>에서 확인해보실 수 있어요. 기능별로 봤을 때 완성 및 검증이 어느정도 되어 안정적으로 서비스를 할 수 있다고 판단되면 그때 웹 서버에 올리고 있어요.
 
* * *
### 언젠가 만들어질 기능들

##### 기본적인 틀 만들기
- [x] 기본적인 데코레이션
- [x] 회원가입
- [x] 로그인
- [x] 로그아웃
- [ ] ID찾기
- [ ] 비밀번호 찾기
- [x] 회원약관 등 기본 규칙 정하기

#### 기본적인 틀 만들기 II
- [x] 유저 역할(role) 부여하기
- [ ] 개인정보 변경하기
- [ ] 계정 영구 정지
- [ ] 회원탈퇴 (이메일 인증 요구하기)
- [ ] 완전하게 ReCAPTCHA 적용하기

#### 그 이후...
- [ ] 간단한 방명록(메시지) 작성하기
- [ ] 포인트 제도(활동점수) 만들기
- [ ] 포인트 송금 제도 만들기 (은근히 재밌다)
- [ ] 포인트 랭킹 시스템 만들기 

* * *
### NECESSITIES
 - 웹 페이지 구동에 필요한 공통 파일들 중, 도배 등 자동화된 봇 활동을 감지하고 차단하기 위하여, Google에서 제공하는 reCAPTCHA v3이 활성화 되어 있습니다. 일단 구글 reCAPTCAH admin console에서 v3버전으로 reCAPTCHA를 발급받은 다음, `/common/reCAPTCHA/` 디레터리 안에 별도로 아래 파일을 만들어 통합을 시켜야 합니다.<br><br>
1. **사이트 측** 통합 (client-side) : `\common\reCAPTCHA\verify_reCAPTCAH_client.html`
 ```html
<!-- reCAPTCHA v3 사이트 측 통합 -->

<script src="https://www.google.com/recaptcha/api.js?render=[여기에_클라이언트_측_reCAPTCHA키를_넣으세요]"></script>

<script>
    grecaptcha.ready(function () {
        grecaptcha.execute("[여기에_클라이언트_측_reCAPTCHA키를_넣으세요]", {
            action: 'homepage'
        }).then(function (token) {
            document.getElementById('g-recaptcha').value = token;
        });
    });
</script>
```
2. **서버 측** 통합 (server-side) : `\common\reCAPTCHA\verify_reCAPTCHA_server.php`
  ```php
  <?php

    function check_reCAPTCHA(){

        $captcha = $_POST['g-recaptcha'];
        $secretKey = '[여기에_서버_측_reCAPTCHA키를_넣으세요]'; 
        $ip = $_SERVER['REMOTE_ADDR'];                           
        
        $data = array(
            'secret' => $secretKey,
            'response' => $captcha,
            'remoteip' => $ip  
        );
        
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $responseKeys = json_decode($response, true);

        if ($responseKeys["success"]) {
            return true;
        } else {
            return false;
        }

    }

?>
  ```
  <br><br>
- **데이터베이스** 테이블 구조
1. `member` 테이블 : 사용자들의 정보에 대한 내용을 다룹니다.
```sql
--
-- 테이블 구조 `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `idx` int(20) NOT NULL auto_increment,
  `id` varchar(30) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `exp` double NOT NULL default '1000',
  `expTransactionQty` double NOT NULL default '0',
  `guestbookQty` int(20) NOT NULL default '0',
  `role` varchar(30) NOT NULL default 'user',
  `lastLoginTime` datetime default NULL,
  `lastLoginIP` varchar(40) default NULL,
  `registrationTime` datetime NOT NULL,
  `registrationIP` varchar(40) NOT NULL,
  PRIMARY KEY  (`idx`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
```
