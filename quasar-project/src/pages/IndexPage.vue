<template>
  <div>
    <DataTable :title="tableTitle" :columns="tableColumns" :rows="getWeather" />

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
      tableTitle: 'Weather',
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
    ...mapActions(useWeatherStore,['getdata'])
  }
}
</script>
