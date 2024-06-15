<script setup>
import { inject } from "@vue/runtime-core";
import { Loader } from "@googlemaps/js-api-loader";
import { useForm } from "@inertiajs/vue3";
import { ref, reactive } from "vue";

const route = inject("route");
let map = ref(null);
defineProps({
    markers: {
        type: Array,
        default: null,
    },
});
const loader = new Loader({
    apiKey: "",
    version: "weekly",
});
const form = useForm({
    name: null,
    description: null,
    latitude: null,
    longitude: null,
});

const deleteForm = useForm({
    id: null,
});

loader.load().then(async () => {
    const { Map } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
    map = new Map(document.getElementById("map"), {
        center: { lat: -34.397, lng: 150.644 },
        zoom: 8,
        mapId: "devMap",
    });
    let marker = new AdvancedMarkerElement({
        map,
        position: null,
    });

    map.addListener("click", (mapsClickEvent) => {
        const latLongAsJSon = mapsClickEvent.latLng.toJSON();
        console.log(latLongAsJSon);
        marker.position = { lat: latLongAsJSon.lat, lng: latLongAsJSon.lng };
        form.latitude = marker.position.lat;
        form.longitude = marker.position.lng;
    });
});
let updateMarker = reactive({
    updateMarkerStateValue: false,
    updateForm: useForm({}),
    setUpdateMarkerState(marker) {
        this.updateMarkerStateValue = true;
        this.updateForm = useForm(marker);
        console.log(this.updateForm);
    },
});
</script>
<script>
export default {
    methods: {
        deleteMarker(id, deleteForm) {
            deleteForm.id = id;
            deleteForm.delete("/Map-marker-delete");
        },

        updateMarker(id, updateForm) {},
    },
};
</script>

<template>
    <div class="flex lg:w-7/12 w-full h-96">
        <div class="h-full w-full" id="map" ref="map"></div>

        <form
            class="grid w-72 gap-4 mt-4 mx-6"
            @submit.prevent="form.post('/Map-marker-submit')"
        >
            <label for="name">Name:</label>
            <input v-model="form.name" id="name" type="text" />
            <label for="description">Description:</label>
            <input v-model="form.description" id="description" type="text" />
            <label for="latitude">Latitude:</label>
            <input
                step="any"
                ref="latitude"
                v-model="form.latitude"
                id="latitude"
                type="number"
            />
            <label for="longitude">Longitude:</label>
            <input
                step="any"
                v-model="form.longitude"
                id="longitude"
                type="number"
            />
            <button :disabled="form.processing" type="submit">Submit</button>
        </form>
    </div>
    <div>
        <table class="">
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Latitude</th>
                <th>Longitude</th>
            </tr>

            <tr class="border" v-for="marker in markers">
                <td class="border">{{ marker.name }}</td>
                <td class="border">{{ marker.description }}</td>
                <td class="border">{{ marker.latitude }}</td>
                <td class="border">{{ marker.longitude }}</td>

                <button
                    class="bg-gray-400"
                    v-on:click.prevent="deleteMarker(marker.id, deleteForm)"
                >
                    delete
                </button>
                <button
                    v-on:click.prevent="
                        updateMarker.setUpdateMarkerState(marker)
                    "
                    class="bg-gray-400 border-l"
                >
                    edit
                </button>
            </tr>
        </table>
        <form
            class="grid w-72 gap-4 mt-4 mx-6"
            @submit.prevent="updateMarker.updateForm.patch('/Map-marker-edit')"
            v-if="updateMarker.updateMarkerStateValue"
        >
            <label for="name">Name:</label>
            <input
                v-model="updateMarker.updateForm.name"
                id="name"
                type="text"
            />
            <label for="description">Description:</label>
            <input
                v-model="updateMarker.updateForm.description"
                id="description"
                type="text"
            />
            <label for="latitude">Latitude:</label>
            <input
                step="any"
                ref="latitude"
                v-model="updateMarker.updateForm.latitude"
                id="latitude"
                type="number"
            />
            <label for="longitude">Longitude:</label>
            <input
                step="any"
                v-model="updateMarker.updateForm.longitude"
                id="longitude"
                type="number"
            />
            <button :disabled="form.processing" type="submit">Submit</button>
        </form>
    </div>
</template>
