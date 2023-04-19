import { router } from '@inertiajs/react';
import { toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

function Payments({ paymentMethods, buttonLabel, balance }) {
    const handleClick = async (paymentMethod) => {
        try {
            const response = await router.post(`/payment/${paymentMethod}/redirect`, { Balance: balance });
        } catch (error) {
            toast.error(`🦄 `, {
                position: "top-right",
                autoClose: 5000,
                hideProgressBar: true,
                closeOnClick: true,
                pauseOnHover: true,
                draggable: true,
                progress: undefined,
                theme: "light",
            });
        }
    };

    return (
        <div>
            {paymentMethods.qiwi && (
                <button className="btn mr-2" onClick={() => handleClick('qiwi')}>
                    {buttonLabel} with QIWI
                </button>
            )}
            {paymentMethods.paypal && (
                <button className="btn mr-2" onClick={() => handleClick('paypal')}>
                    {buttonLabel} with PayPal
                </button>
            )}
            <a href="#" className="btn">Close</a>
        </div>
    );
}

export default Payments;
