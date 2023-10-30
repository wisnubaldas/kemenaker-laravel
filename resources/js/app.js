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
            isEdit:window.isEditDraft,
            tenderData:window.tenderData,
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
            this.tenderData.usulan_tender_details.push( {
                berkaslist:[]
            });
            vueIndex = this.tenderData.usulan_tender_details.length;
        },
        onAddBerkas(tender){
            tender.usulan_tender_detail_doc.push( {
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
            this.tenderData.usulan_tender_usul_pokja.push({
                nip:""
            })
        }
    },
}).mount('#app')