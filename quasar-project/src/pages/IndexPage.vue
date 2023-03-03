<template>
  <q-page class="flex flex-center">
    <img
      alt="Quasar logo"
      src="~assets/quasar-logo-vertical.svg"
      style="width: 200px; height: 200px"
    >
  </q-page>
</template>

<script>
import { defineComponent } from 'vue'
import {mapActions} from "pinia";
import {useCounterStore} from "stores/example-store";

export default defineComponent({
  name: 'IndexPage',
  created() {
    this.getdata()
  },
  methods:{
    ...mapActions(useCounterStore,['getdata'])
  }
})
</script>
