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
            tabusulan_active:1,
            rowdraftactive:null,
            file_surat_usulan_name:null
        }
    },
    methods: {
        onAdd(){
            this.tenderlist.push( {
                jenis_tender:"",
                nama_tender:"",
                
            });
        },
        saveDraft(){
            this.$refs.draftForm.submit();
        },
        openFilePicker(namainput) {
            this.$refs[namainput].click();
        },
        updateFileName(event) {
          
            var fileName = event.target.files[0] ? event.target.files[0].name : '';
            this.file_surat_usulan_name=fileName;

        }
    },
}).mount('#app')