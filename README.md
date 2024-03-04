## タイトル
d-game (仮)
現在も開発中のため、未完成となります。

### 概要
最短距離を出したユーザーが勝つゲームです。

流れは下記の通りに進めます
1. ユーザー名を登録してゲームスタート（最大4人）
2. ランダムに目的地が決まる
3. ユーザーが1人ずつ順番に郵便番号を決めるスロットを回す（郵便番号にヒットする地域が無い場合は、近い郵便番号から割り出します）
4. 弾き出した郵便番号の緯度経度と目的地の緯度経度を直線で結んだ距離を算出（単位: km）
5. 最も目的地と近い距離を出したユーザーが勝利

### ゲームデモ動画
ローカル環境で録画しているため、動作がもたついてる点はご了承ください...

https://github.com/Shokimac/distance-game/assets/64714255/bbdc0700-6d02-46c9-8890-920cfdeda783

### 技術スタック
- PHP 8.1.24
- Laravel 10.25.2
- Vue.js 3.3.4
- TypeScript 5.2.2
- MySQL 8.0.34
- AWS CDK 2.100.0
- Docker / Docker-compose
- GoogleMaps API

バックエンド側でドメイン駆動設計を取り入れてみています。

## 機能
- ユーザー登録
- スロット
- 2地点距離算出
- 結果表示
