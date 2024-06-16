<script setup>
import { Head } from "@inertiajs/vue3";
defineProps({
    weatherData: {
        type: Object,
    },
});
</script>

<template>
    <Head title="Weather"></Head>
    <div>
        <img
            style="background-color: gray"
            :src="`http://openweathermap.org/img/wn/${weatherData.weather[0].icon}@2x.png`"
            alt="Weather icon"
        />
        <span>{{ weatherData.name }}</span>
        <span>{{ weatherData.main.temp }}</span>
        <span>{{ weatherData.weather[0].description }}</span>
    </div>
    <div>
        <h1>Weather</h1>
        <ul>
            <li>Feels like {{ weatherData.main.feels_like }}</li>
            <li>Humidity {{ weatherData.main.humidity }}</li>
            <li>Pressure {{ weatherData.main.pressure }}</li>
            <li>Temp min {{ weatherData.main.temp_min }}</li>
            <li>Temp max {{ weatherData.main.temp_max }}</li>
        </ul>
        <h1>Wind</h1>
        <ul>
            <li>Wind speed {{ weatherData.wind.speed }}</li>
            <li>Wind degrees {{ weatherData.wind.deg }}</li>
        </ul>
    </div>
    <div><a class="bg-slate-400" href="/">Return home</a></div>
</template>
