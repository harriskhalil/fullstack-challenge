import { defineStore } from 'pinia';
import {useGlobalStore} from "stores/GlobalStore";
import {Notify} from "quasar";

export const useWeatherStore = defineStore('weather', {
  state: () => ({
    weather:[],
  }),
  getters: {
    getWeather: (state) => state.weather,
  },
  actions: {
    async getdata(){
      const global_store= useGlobalStore();
      return await global_store.apiRequest({
        url: "weather",
        method: "GET",
      }).then((response)=>{
        if (response.status===200){
          this.weather = response.data.data
          Notify.create({
            color: "green",
            position: "top",
            message: response.data.message,
          });
        }

        return Promise.resolve(response);
      }).catch((error)=>{
        console.log("ERROR" + error);
        return Promise.reject(error);
      })
    }
  },
});
