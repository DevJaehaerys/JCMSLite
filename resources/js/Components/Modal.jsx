import { useState } from "react";
import axios from "axios";
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
function Modal({ selectedItem, handleModalClose, auth }) {
    const [error, setError] = useState("");



    const handleBuyClick = () => {
        if (auth) {
            axios.post("/buyItem", { itemid: selectedItem.id }, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then((response) => {
                    toast.success(`🦄 ${response.data.message} `, {
                        position: "top-right",
                        autoClose: 5000,
                        hideProgressBar: true,
                        closeOnClick: true,
                        pauseOnHover: true,
                        draggable: true,
                        progress: undefined,
                        theme: "light",
                    });
                })
                .catch((error) => {
                    if (error.response.status === 403 && error.response.data.message === 'Not enough balance') {
                        toast.error(`🦄 ${error.response.data.message} `, {
                            position: "top-right",
                            autoClose: 5000,
                            hideProgressBar: true,
                            closeOnClick: true,
                            pauseOnHover: true,
                            draggable: true,
                            progress: undefined,
                            theme: "light",
                        });
                    } else {
                        alert('500 error, contact Jaehaerys#7777')
                    }
                });
        } else {
            setError("Please log in to buy this item");
        }
    };



    return (
        <>
            <ToastContainer />

            <input type="checkbox" id="my-modal" className="modal-toggle" />
            <div className="modal">
                <div style={{ minHeight: '500px' }} className="modal-box">
                {selectedItem && (
                        <>
                            <h3 className="font-bold text-lg text-center">
                                {selectedItem.name}
                            </h3>
                            <p className="py-4 text-center">{selectedItem.about}</p>
                            <img
                                className="w-72 m-auto"
                                src={selectedItem.image}
                                alt={selectedItem.name}
                            />
                        </>
                    )}
                    <div className="modal-action flex justify-center">
                        <label htmlFor="my-modal" className="btn" onClick={handleModalClose}>
                            Close
                        </label>
                        <label className="btn" onClick={handleBuyClick}>
                            Buy
                        </label>
                    </div>
                    {error && (
                        <div className="alert alert-error mt-5 shadow-lg">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" className="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>{error}</span>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </>
    );
}

export default Modal;
