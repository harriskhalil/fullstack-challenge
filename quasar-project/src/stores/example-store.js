import { defineStore } from 'pinia';
import {useGlobalStore} from "stores/GlobalStore";
import {Notify} from "quasar";

export const useCounterStore = defineStore('counter', {
  state: () => ({
    counter: 0,
  }),
  getters: {
    doubleCount: (state) => state.counter * 2,
  },
  actions: {
    increment() {
      this.counter++;
    },
    async getdata(){
      const global_store= useGlobalStore();
      return await global_store.apiRequest({
        url: "weather",
        method: "GET",
      }).then((response)=>{
        console.log(response)
        Notify.create({
          color: "green",
          position: "top",
          message: response.data.message,
        });

        return Promise.resolve(response);
      }).catch((error)=>{
        console.log("ERROR" + error);
        return Promise.reject(error);
      })

    }
  },
});
