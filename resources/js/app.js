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
            ],
            tabusulan_active:1
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