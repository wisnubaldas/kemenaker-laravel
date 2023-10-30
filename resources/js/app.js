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
            docname:{

            },
            tabusulan_active:1,
            rowdraftactive:null,
            file_surat_usulan_name:null,
            members:[
                {}
            ]
        }
    },
    methods: {
        checkExist(name){
            var ret=false;
            if(this.docname[name]){
                ret=true
            }
            return ret;
        },
        onAdd(){
            this.tenderlist.push( {
                berkaslist:[]
            });
            vueIndex = this.tenderlist.length;
        },
        onAddBerkas(tender){
            tender.berkaslist.push( {
                nama_berkas:"",
                
            });
        },
        saveDraft(){
            this.$refs.draftForm.submit();
        },
        openDocPicker(namainput) {
            this.$refs[namainput][0].click();
        },
        openFilePicker(namainput) {
            this.$refs[namainput].click();
        },
        updateDocName(event,name) {
            var fileName = event.target.files[0] ? event.target.files[0].name : '';
            
            this.docname[name]=fileName;
        },
        updateFileName(event) {
            var fileName = event.target.files[0] ? event.target.files[0].name : '';
            this.file_surat_usulan_name=fileName;
        },
        onAddAnggota(){
            this.members.push({})
        }
    },
}).mount('#app')