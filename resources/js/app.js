import "./bootstrap";
import Swal from "sweetalert2";
import axios from "axios";

const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
const { createApp, ref } = Vue;
var i = 0;

createApp({
    setup() {
        const message = ref("Hello vue!");

        return {
            message,
        };
    },

    data() {
        return {
            pathmodalactive: null,
            isEdit: window.isEditDraft,
            tenderData: window.tenderData,
            docname: {},
            tabusulan_active: 1,
            rowdraftactive: null,
            file_surat_usulan_name: null,
            members: [{}],
            catatan:""
        };
    },
    methods: {
        checkExist(name) {
            var ret = false;
            if (this.docname[name]) {
                ret = true;
            }
            return ret;
        },
        onAdd() {
            this.tenderData.usulan_tender_details.push({
                usulan_tender_detail_doc: [],
            });
            vueIndex = this.tenderData.usulan_tender_details.length;
        },
        onAddBerkas(tender) {
            tender.usulan_tender_detail_doc.push({
                nama_berkas: "",
            });
        },
        saveDraft() {
            this.$refs.draftForm.submit();
        },
        openDocPicker(namainput) {
            this.$refs[namainput][0].click();
        },
        openFilePicker(namainput) {
            this.$refs[namainput].click();
        },
        updateDocName(event, name) {
            var fileName = event.target.files[0]
                ? event.target.files[0].name
                : "";

            this.docname[name] = fileName;
        },
        updateFileName(event) {
            var fileName = event.target.files[0]
                ? event.target.files[0].name
                : "";
            this.file_surat_usulan_name = fileName;
        },
        onAddAnggota() {
            this.tenderData.usulan_tender_usul_pokja.push({
                nip: "",
            });
        },
        delTender(item, index) {
            if (item.id) {
                item.is_del = true;
            } else {
                this.tenderData.usulan_tender_details.splice(index, 1);
            }
        },
        delDoc(item, doc, indexdoc) {
            if (doc.berkas) {
                doc.is_del = true;
            } else {
                item.usulan_tender_detail_doc.splice(indexdoc, 1);
            }
        },
        delMember(item, index) {
            if (item.id) {
                item.is_del = true;
            } else {
                this.tenderData.usulan_tender_usul_pokja.splice(index, 1);
            }
        },
        sendUsulan(tenderId) {
            Swal.fire({
                title: "Apakah data ini akan dikirim?",
                text: "Pastikan data telah di input dengan benar!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya! Kirim",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .post(`/usulan-tender/send/${tenderId}`)
                        .then((response) => {
                            Swal.fire({
                                title: "Terkirim!",
                                text: "Usulan Tender Telah Terkirim.",
                                icon: "success",
                                didClose: () => {
                                    // Redirect ke halaman '/usulan-tender' setelah SweetAlert ditutup
                                    window.location.href = '/usulan-tender';
                                }
                            });
                            
                         //   window.location.href = '/usulan-tender';
                        })
                        .catch((error) => {
                            // Handle error jika request gagal
                            console.error(error); // Outputkan pesan error jika diperlukan
                            Swal.fire(
                                "Error!",
                              error.response.data.message,
                                "error"
                            );
                        });
                }
            });
        },
        approveUsulan(tenderId) {
            Swal.fire({
                title: "Apakah data ini akan diterima?",
                text: "Pastikan anda telah yakin menerima data ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya! Terima",
            }).then((result) => {
                if (result.isConfirmed) {
                 
                    axios
                        .post(`/usulan-tender/approve/${tenderId}`,{catatan:this.catatan})
                        .then((response) => {
                            Swal.fire({
                                title: "Diterima!",
                                text: "Usulan Tender Telah Diterima.",
                                icon: "success",
                                didClose: () => {
                                    // Redirect ke halaman '/usulan-tender' setelah SweetAlert ditutup
                                    window.location.reload()
                                }
                            });
                            
                         //   window.location.href = '/usulan-tender';
                        })
                        .catch((error) => {
                            // Handle error jika request gagal
                            console.error(error); // Outputkan pesan error jika diperlukan
                            Swal.fire(
                                "Error!",
                              error.response.data.message,
                                "error"
                            );
                        });
                }
            });
        },
        rejectUsulan(tenderId) {
            Swal.fire({
                title: "Apakah data ini akan ditolak?",
                text: "Pastikan anda telah yakin menolak data ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya! Tolak",
            }).then((result) => {
                if (result.isConfirmed) {
                 
                    axios
                        .post(`/usulan-tender/reject/${tenderId}`,{catatan:this.catatan})
                        .then((response) => {
                            Swal.fire({
                                title: "Diterima!",
                                text: "Usulan Tender Telah Ditolak",
                                icon: "success",
                                didClose: () => {
                                    // Redirect ke halaman '/usulan-tender' setelah SweetAlert ditutup
                                    window.location.reload()
                                }
                            });
                            
                         //   window.location.href = '/usulan-tender';
                        })
                        .catch((error) => {
                            // Handle error jika request gagal
                            console.error(error); // Outputkan pesan error jika diperlukan
                            Swal.fire(
                                "Error!",
                              error.response.data.message,
                                "error"
                            );
                        });
                }
            });
        },
    },
}).mount("#app");
"use strict";
var KTProjectOverview = (function () {
    var t = KTUtil.getCssVariableValue("--bs-primary"),
        e = KTUtil.getCssVariableValue("--bs-light-primary"),
        a = KTUtil.getCssVariableValue("--bs-success"),
        r = KTUtil.getCssVariableValue("--bs-light-success"),
        o = KTUtil.getCssVariableValue("--bs-gray-200"),
        n = KTUtil.getCssVariableValue("--bs-gray-500");
    return {
        init: function () {
            var s, i;
            !(function () {
                var t = document.getElementById("project_overview_chart");
              
                if (t) {
                    var chartData = document.getElementById("project_overview_chart").getAttribute("data-chart-data");
                    var parsedData = JSON.parse(chartData);
                    
                   
                if (chartData) {
                   
                    var e = t.getContext("2d");
                    new Chart(e, {
                        type: "doughnut",
                        data:parsedData,
                        options: {
                            chart: { fontFamily: "inherit" },
                            cutoutPercentage: 75,
                            responsive: !0,
                            maintainAspectRatio: !1,
                            cutout: "75%",
                            title: { display: !1 },
                            animation: { animateScale: !0, animateRotate: !0 },
                            tooltips: {
                                enabled: !0,
                                intersect: !1,
                                mode: "nearest",
                                bodySpacing: 5,
                                yPadding: 10,
                                xPadding: 10,
                                caretPadding: 0,
                                displayColors: !1,
                                backgroundColor: "#20D489",
                                titleFontColor: "#ffffff",
                                cornerRadius: 4,
                                footerSpacing: 0,
                                titleSpacing: 0,
                            },
                            plugins: { legend: { display: !1 } },
                        },
                    });
                }
            }
            })()
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTProjectOverview.init();
});

