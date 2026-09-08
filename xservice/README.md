# lion3 xservice / account

PBG 회차 결과 등록 + 정산을 **하나의 프로세스**에서 처리합니다.

## 실행

`account\run_startup.bat`

## 기동 시

1. **백필**: 어제 1회차 ~ 기동 직전 완료 회차까지 `powerball.draw_results` → Lion `round_pball`
2. **미정산 일괄**: `bet_state=1` 이고 회차 결과(`round_state=1`) 있는 배팅 정산

## 루프 (5분마다)

1. 직전 슬롯 결과 DB 직조회·등록  
2. 정산  
3. 0.5초 폴링

## .env

```
DB_*                  # Lion (예: lion3star)
POWERBALL_DB_*        # Powerball (로컬 예: powerball)
POWERBALL_BASE_URL=   # 웹 미니뷰용
```

## 로그

`account\log\acc_YYYY-MM-DD`
