import {useState} from "react";
import Modal from "@/Components/Modal";
import axios from "axios";

function ShopCard({auth, shop}) {
    const [selectedItem, setSelectedItem] = useState(null);
    const [isModalOpen, setIsModalOpen] = useState(false);

    const handleModalClose = () => {
        setSelectedItem(null);
        setIsModalOpen(false);
    };

    const handleBuyBtnClick = async (itemId) => {
        try {
            const response = await axios.post(
                "/getItemInfo",
                {
                    itemid: itemId,
                },
                {
                    headers: {
                        "Content-Type": "application/json",
                    },
                }
            );
            const data = response.data;
            setSelectedItem(data);
            setIsModalOpen(true);
        } catch (error) {
            console.error(error);
        }
    };

    const handleBuyItem = async (itemId) => {
        try {
            const response = await axios.post(
                "/buyItem",
                {
                    itemid: itemId,
                },
                {
                    headers: {
                        "Content-Type": "application/json",
                    },
                }
            );
            console.log("Item bought successfully");
        } catch (error) {
            console.error(error);
        }
    };


    return (
        <>
            <Modal auth={auth} selectedItem={selectedItem} handleModalClose={handleModalClose}
                   handleBuyItem={handleBuyItem}/>

            <div
                className="grid grid-flow-row gap-8 text-neutral-600 bg-base-300 p-8 shadow-2xl sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                {shop.map((item) => (
                    <div key={item.id} className="card w-72 bg-base-200 shadow-xl">
                        <figure className="p-4">
                            <img className="w-72" src={item.image} alt={item.name}/>
                        </figure>
                        <div className="card-body">
                            <h2 className="card-title text-base-content">{item.name}</h2>
                            <p className="text-base-content">{item.about}</p>
                            <label onClick={() => handleBuyBtnClick(item.id)} htmlFor="my-modal"
                                   className="btn btn-primary w-auto">Buy</label>
                        </div>
                    </div>
                ))}
            </div>

        </>
    );
}

export default ShopCard;
