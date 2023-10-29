import './bootstrap';
const { createApp, ref } = Vue
var i = 0;


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
                    nama_tender:"",
                    berkaslist:[
                        {
                            nama_berkas:"",
                        }
                    ],
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
                
            });
            vueIndex = this.tenderlist.length;
        },
        onAddBerkas(tender){
            tender.berkaslist.push( {
                nama_berkas:"",
            });
        },
        saveDraft(){
            console.log("FORM",this.$refs.draftForm)

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