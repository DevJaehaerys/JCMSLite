import React from 'react';

const Payment = ({ methods }) => {
    return (
        <div className="payment-methods">
            {methods.map(method => (
                <div key={method.id} className="payment-method">
                    <img src={method.icon} alt={method.name} />
                    <h3>{method.name}</h3>
                    <p>Minimum amount: {method.minAmount}</p>
                    {method.enabled ? (
                        <p>Status: enabled</p>
                    ) : (
                        <p>Status: disabled</p>
                    )}
                </div>
            ))}
        </div>
    );
};

export default Payment;
