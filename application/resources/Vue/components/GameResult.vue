<script setup lang="ts">
import SubmitButton from './ViewParts/SubmitButton.vue';
</script>

<template>
  <div class="flex flex-col h-screen">
    <h1
      class="mt-6 text-forest flex align-center justify-center font-din text-3xl relative font-extrabold
        before:content-[''] before:h-0.5 before:w-12 before:bg-forest before:mr-4 before:absolute before:top-1/3 before:left-14
        after:content-[''] after:h-0.5 after:w-12 after:bg-forest after:ml-4 after:absolute after:top-1/3 after:right-14">
      結果発表</h1>

    <div class="mt-2 w-full bg-[url('/assets/images/congrats.svg')] bg-contain bg-no-repeat grow relative">
      <div class="w-4/5 absolute left-10 top-48 bg-white">
        <div class="w-full py-1 bg-white border-2 border-forest">
          <p class="text-center text-xl"><span class="text-forest font-bold">田中 太郎</span>さん</p>
          <p class="text-center text-lg font-bold">目的地までの距離 <span
              class="text-forest font-bold text-3xl font-din">813</span>
            km
          </p>
        </div>
        <div class="flex w-full mt-2">
          <div class="w-2/12">
            <img :src="`/assets/icons/rank_flag_2.svg`" :alt="`2着ランクアイコン`" class="inline mr-4 max-w-full">
          </div>
          <div class="w-10/12 flex">
            <div class="w-1/2 font-bold text-center">
              <span class="text-lg">〒</span><span class="text-forest text-3xl font-din">578</span><span
                class="font-extrabold text-xl">-</span><span class="text-forest text-3xl font-din">0983</span>
              <p class="truncate">福島県福島市下谷寺</p>
            </div>
            <div class="w-1/2 flex flex-col">
              <div class="w-full text-right font-bold">
                <span class="text-forest font-din text-3xl">1,663</span>km
              </div>
              <div class="w-full text-sm truncate">
                <img :src="`/assets/icons/map-pin-user-fill.svg`" alt="ユーザーアイコン" class="inline mr-0.5">テストプレイヤー2さん
              </div>
            </div>
          </div>
        </div>
        <div class="flex w-full mt-2">
          <div class="w-12">
            <img :src="`/assets/icons/rank_flag_3.svg`" :alt="`3着ランクアイコン`" class="inline mr-4 max-w-full">
          </div>
          <div class="w-full flex">
            <div class="w-1/2 font-bold text-center">
              <span class="text-lg">〒</span><span class="text-forest text-3xl font-din">150</span><span
                class="font-extrabold text-xl">-</span><span class="text-forest text-3xl font-din">8510</span>
            </div>
            <div class="w-1/2 flex flex-col">
              <div class="w-full text-right font-bold">
                <span class="text-forest font-din text-3xl">2,121</span>km
              </div>
              <div class="w-full text-sm truncate">
                <img :src="`/assets/icons/map-pin-user-fill.svg`" alt="ユーザーアイコン" class="inline mr-0.5">ダミー二郎さん
              </div>
            </div>
          </div>
        </div>
        <div class="flex w-full mt-2">
          <div class="w-12">
            <img :src="`/assets/icons/rank_flag_4.svg`" :alt="`4着ランクアイコン`" class="inline mr-4 max-w-full">
          </div>
          <div class="w-full flex">
            <div class="w-1/2 font-bold text-center">
              <span class="text-lg">〒</span><span class="text-forest text-3xl font-din">900</span><span
                class="font-extrabold text-xl">-</span><span class="text-forest text-3xl font-din">0021</span>
            </div>
            <div class="w-1/2 flex flex-col">
              <div class="w-full text-right font-bold">
                <span class="text-forest font-din text-3xl">3,093</span>km
              </div>
              <div class="w-full text-sm truncate">
                <img :src="`/assets/icons/map-pin-user-fill.svg`" alt="ユーザーアイコン" class="inline mr-0.5">テスト 太郎さん
              </div>
            </div>
          </div>
        </div>
        <div class="mt-2 w-full mx-auto">
          <SubmitButton label="もう一度遊ぶ" />
        </div>
        <div class="w-3/4 mt-5 mx-auto">
          <SubmitButton label="TOPに戻る" />
        </div>
      </div>
    </div>
  </div>
</template>