import { Box, Paper, Typography, TextField, Button } from '@mui/material';
import { useState } from 'react';
import { login } from '../Api/auth';
import { useNavigate } from 'react-router-dom';

export default function Login() {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const navigate = useNavigate();

    const onSubmit = async () => {
        try {
            const response = await login(email, password);
            localStorage.setItem('token', response.token);
            alert("Login successful");
            navigate('/products');
        } catch (error) {
            alert(error.response.data.message);
        }
    }

    return (
        <Box sx={{ display: 'flex', justifyContent: 'center', alignItems: 'center', minHeight: '80vh' }}>
          <Paper elevation={3} sx={{ p: 4, width: '100%', maxWidth: 400 }}>
            <Typography variant="h6" gutterBottom>Welcome back</Typography>
            <Typography variant="body2" sx={{ mb: 2 }}>Please enter your details to sign in</Typography>
            <TextField label="Email" type="email" value={email} onChange={(e) => setEmail(e.target.value)} fullWidth margin="normal" />
            <TextField label="Password" type="password" value={password} onChange={(e) => setPassword(e.target.value)} fullWidth margin="normal" />
            <Button type='button' onClick={onSubmit} variant="contained" fullWidth sx={{ mt: 2 }}>Login</Button>
          </Paper>
        </Box>
      );
}