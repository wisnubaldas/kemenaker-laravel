import './bootstrap';
const { createApp, ref } = Vue

createApp({
    setup() {
      const message = ref('Hello vue!')
      return {
        message
      }
    },
    data() {
        return {
            tenderlist:[
                {
                    jenis_tender:"",
                    nama_tender:""
                }
            ]
        }
    },
    methods: {
        onAdd(){
            this.tenderlist.push( {
                jenis_tender:"",
                nama_tender:""
            });
        }
    },
}).mount('#app')