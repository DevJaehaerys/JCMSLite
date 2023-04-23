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
        <div className="flex flex-col justify-center">
            {paymentMethods.qiwi && (
                <button className="btn" onClick={() => handleClick('qiwi')}>
                    {buttonLabel} with QIWI
                </button>
            )}
            {paymentMethods.paypal && (
                <button className="btn" onClick={() => handleClick('paypal')}>
                    {buttonLabel} with PayPal
                </button>
            )}
            {paymentMethods.stripe && (
                <button className="btn" onClick={() => handleClick('stripe')}>
                    {buttonLabel} with Stripe
                </button>
            )}
            {paymentMethods.enot && (
                <button className="btn" onClick={() => handleClick('enot')}>
                    {buttonLabel} with Enot
                </button>
            )}
            {paymentMethods.fk && (
                <button className="btn" onClick={() => handleClick('fk')}>
                    {buttonLabel} with Free Kassa
                </button>
            )}
            <a href="#" className="btn">Close</a>
        </div>
    );
}

export default Payments;
