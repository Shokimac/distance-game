## distance-game (仮)
現在、開発中のため、まだ未完成となります...
### 概要
最短距離を出したユーザーが勝つゲームです。

<img width="349" alt="スクリーンショット 2024-02-05 21 29 02" src="https://github.com/Shokimac/distance-game/assets/64714255/eb42b78d-3dec-49c7-ae3d-f834239a3293">

流れは下記の通りに進めます
1. ユーザー名を登録してゲームスタート（最大4人）
2. ランダムに目的地が決まる
3. ユーザーが1人ずつ順番に郵便番号を決めるスロットを回す（郵便番号にヒットする地域が無い場合は、近い郵便番号から割り出します）
4. 弾き出した郵便番号の緯度経度と目的地の緯度経度を直線で結んだ距離を算出（単位: km）
5. 最も目的地と近い距離を出したユーザーが勝利

### ゲーム画面

<img width="349" alt="スクリーンショット 2024-02-05 21 31 32" src="https://github.com/Shokimac/distance-game/assets/64714255/8239c03b-0d63-48f9-b937-fa1f9ba4fa63">
<img width="338" alt="スクリーンショット 2024-02-05 21 33 45" src="https://github.com/Shokimac/distance-game/assets/64714255/7fbf7f36-09e8-45bb-b44c-443e0ab7063c">
<img width="342" alt="スクリーンショット 2024-02-05 21 35 04" src="https://github.com/Shokimac/distance-game/assets/64714255/45364619-54e3-40ac-99d8-c22b2a5e47de">
<img width="349" alt="スクリーンショット 2024-02-05 22 15 35" src="https://github.com/Shokimac/distance-game/assets/64714255/c4fcde98-34db-403d-99b1-1ac3fedbf94c">


### 技術スタック
- PHP 8.1.24
- Laravel 10.25.2
- Vue 3.3.4
- TypeScript 5.2.2
- MySQL 8.0.34
- AWS CDK 2.100.0
- Docker / Docker-compose
- GoogleMaps API

## 機能
- ユーザー登録
- スロット機能
- 距離算出
- 結果表示
