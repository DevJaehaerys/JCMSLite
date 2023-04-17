import { useState } from 'react';
import { router } from '@inertiajs/react'
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
function AuthDropdown({auth}) {
    const [balance, setBalance] = useState('');

    const handleClick = async () => {
        try {
            const response = await router.post('/payment/qiwi/redirect', { Balance: balance });
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

    const handleChange = (event) => {
        setBalance(event.target.value);
    };

    return (

        <div className="dropdown dropdown-end">
            <ToastContainer />
            <div className="modal" id="my-modal-3">
                <div className="flex items-center justify-center flex-col modal-box">
                    <h3 className="font-bold text-lg">Deposit</h3>
                    <div className="form-control">
                        <label className="label">
                            <span className="label-text">Enter amount</span>
                        </label>
                        <label className="input-group">
                            <input type="text" placeholder="0.01" className="input input-bordered" value={balance} onChange={handleChange} />
                            <span>RUB</span>
                        </label>
                    </div>
                    <div className="modal-action">
                        <button className="btn" onClick={handleClick}>
                            Buy with QIWI
                        </button>
                        <a href="#" className="btn">Close</a>
                    </div>
                </div>
            </div>
            <label tabIndex={0} className="btn btn-ghost btn-circle avatar">
                <div className="w-10 rounded-full">
                    <img src={auth.avatar}  alt='user avatar'/>
                </div>
            </label>
            <ul tabIndex={0}
                className="mt-3 p-2 shadow menu menu-compact dropdown-content bg-base-200 rounded-box w-52">
                <li>
                    <a href="#my-modal-3"  className="justify-between">
                        Deposit
                        <span className="badge">$</span>
                    </a>
                </li>
                <li><a>Logout</a></li>
            </ul>
        </div>
    );
}

export default AuthDropdown;
