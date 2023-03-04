<template>
  <div class="q-pa-md">
    <q-table
      :title="title"
      :rows="rows"
      :columns="columns"
      row-key="name"
      @row-click="onRowClick"
    />
  </div>
</template>
<script>
export default {
  name: 'DataTable',
  emits:['rowClick'],
  props: {
    title: {
      type: String,
      default: 'Weather'
    },
    columns: {
      type: Array,
      required: true
    },
    rows: {
      type: Array,
      required: true
    }
  },
  methods: {
    onRowClick(event, row) {
      this.$emit('rowClick',row)

    }
  }
}
</script>
