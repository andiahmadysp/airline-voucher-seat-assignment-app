const Button = ({ variant = 'primary', children, ...args }) => {
    return (
        <button className={`btn btn-${variant}`} {...args}>
            {children}
        </button>
    );
};

export default Button;