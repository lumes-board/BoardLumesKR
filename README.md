<p align = "center">
 <img src="https://img.shields.io/github/languages/code-size/lumes-board/BoardLumesKR">
 <img src="https://img.shields.io/tokei/lines/github/lumes-board/BoardLumesKR">
 <img src="https://img.shields.io/github/languages/top/lumes-board/BoardLumesKR">
 <img src="https://img.shields.io/website?down_color=lightgray&down_message=offline&up_color=blue&up_message=online&url=http%3A%2F%2Fboard.lumes.kr">
</p>

# BoardLumesKR
**엉망진창 망가져버린 login.lumes.kr 다시 만들기**   
이전 프로젝트 : https://github.com/x3onkait/LoginLumesKR
 
* * *
### 언젠가 만들어질 기능들
`지금은 기회가 되지 않지만... 언젠가 취약점으로 박살 난 login.lumes.kr을 어떻게든 해 보고 싶다.`   

-> **Prepared Statement** 방식으로 SQL을 다루고 입출력 모두에 `htmlspecialchars()` 같은 함수를 적용한다. 입출력 필터링을 신경쓰고, 어뷰징이나 공백 테러, 도배질 등을 막기 위해 신경을 쓰도록 한다.

##### 기본적인 틀 만들기
- [x] 기본적인 데코레이션
- [x] 회원가입
- [x] 로그인
- [x] 로그아웃
- [ ] ID찾기
- [ ] 비밀번호 찾기
- [x] 회원약관 등 기본 규칙 정하기

#### 기본저인 틀 만들기 II
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
