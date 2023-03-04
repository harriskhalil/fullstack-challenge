<template>
  <div>
    <DataTable :title="tableTitle" :columns="tableColumns" :rows="getWeather" @rowClick="(e)=>showData(e)" />
    <div class="q-pa-md">
      <q-dialog v-model="dialog" persistent>
        <q-card class="q-pa-md">
          <q-card-actions align="center">
            <q-avatar icon="person" color="secondary" text-color="white" size="md" />
            <span class="q-mx-sm">{{weather.name}}</span>
            <q-btn flat  icon="close" color="primary" class="q-ml-xl"  v-close-popup />
          </q-card-actions>
          <q-card-section class="row items-center">
            <div class="q-ma-sm">
              <q-avatar icon="description" color="secondary" text-color="white" size="md" />
              <span class="q-ml-sm">{{weather.description}}</span>
            </div>
            <div class="q-ma-sm">
              <q-avatar icon="thermostat" color="secondary" text-color="white" size="md" />
              <span class="q-ml-sm">Temp: {{weather.temperature}}</span>
              <span class="text-caption q-ma-sm">Feels like //{{weather.user_weather.main.feels_like}}</span>
            </div>
          </q-card-section>
          <q-card-section class="row items-center">
            <div class="q-ma-sm">
              <q-avatar icon="description" color="secondary" text-color="white" size="md" />
              <span class="q-ml-sm">Humidity: {{weather.user_weather.main.humidity}}</span>
            </div>
            <div class="q-ma-sm">
              <q-avatar icon="thermostat" color="secondary" text-color="white" size="md" />
              <span class="q-ml-sm">Ground Level: {{weather.user_weather.main.grnd_level}}</span>
            </div>
          </q-card-section>
          <q-card-section class="row items-center">
            <div class="q-ma-sm">
              <q-avatar icon="description" color="secondary" text-color="white" size="md" />
              <span class="q-ml-sm">Pressure: {{weather.user_weather.main.pressure}}</span>
            </div>
            <div class="q-ma-sm">
              <q-avatar icon="thermostat" color="secondary" text-color="white" size="md" />
              <span class="q-ml-sm">Sea Level: {{weather.user_weather.main.sea_level}}</span>
            </div>
          </q-card-section>
          <q-card-section class="row items-center">
            <div class="q-ma-sm">
              <q-avatar icon="description" color="secondary" text-color="white" size="md" />
              <span class="q-ml-sm">Min Temp: {{weather.user_weather.main.temp_min}}</span>
            </div>
            <div class="q-ma-sm">
              <q-avatar icon="description" color="secondary" text-color="white" size="md" />
              <span class="q-ml-sm">Max Temp: {{weather.user_weather.main.temp_max}}</span>
            </div>
          </q-card-section>
          <q-card-section class="row items-center">
            <div class="q-ma-sm">
              <q-avatar icon="description" color="secondary" text-color="white" size="md" />
              <span class="q-ml-sm">Sunrise: {{weather.user_weather.sys.sunrise}}</span>
            </div>
            <div class="q-ma-sm">
              <q-avatar icon="description" color="secondary" text-color="white" size="md" />
              <span class="q-ml-sm">Sunset: {{weather.user_weather.sys.sunset}}</span>
            </div>
          </q-card-section>

        </q-card>
      </q-dialog>
    </div>
  </div>
</template>
<script>
import DataTable from "components/DataTable.vue";
import {mapActions, mapState} from "pinia";
import {useWeatherStore} from "stores/example-store";
export default {
  components: {
    DataTable,
  },
  created() {
    this.getdata()

  },

  data() {
    return {
      weather:'',
      dialog: false,
      tableTitle: 'Users',
      tableColumns: [
        {
          required: true,
          label: 'ID',
          align: 'left',
          field: 'id',
          sortable: true
        },
        {
          required: true,
          label: 'Name',
          align: 'left',
          field: 'name',
          sortable: true
        },
        {align: 'center', label: 'Email', field: 'email', sortable: true},
        {

          required: true,
          label: 'Latitude',
          align: 'left',
          field: 'latitude',
          sortable: true
        },
        {
          required: true,
          label: 'Longitude',
          align: 'left',
          field: 'longitude',
          sortable: true
        },
        {
          required: true,
          label: 'Description',
          align: 'left',
          field: 'description',
          sortable: true
        },
        {
          required: true,
          label: 'Temperature',
          align: 'left',
          field: 'temperature',
          sortable: true
        },
      ],
    }
  },
  computed:{
    ...mapState(useWeatherStore,['getWeather'])
  },
  methods:{
    ...mapActions(useWeatherStore,['getdata']),
    showData(e){
      this.dialog= true
      this.weather= e;
    }
  }
}
</script>
