<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="content-section">
    <div class="card">
        <div class="card-header-simple">
            <h3>🎲 Generador Automático de Códigos</h3>
            <a href="<?php echo BASE_URL; ?>codigos/index" class="btn btn-secondary">
                ← Volver a Códigos
            </a>
        </div>

        <div class="generador-container">
            <div class="generador-info">
                <div class="info-box-gen">
                    <h4>💡 ¿Cómo funciona?</h4>
                    <ol>
                        <li>Selecciona la categoría del producto</li>
                        <li>El sistema genera automáticamente el siguiente código disponible</li>
                        <li>Copia el código y úsalo al crear tu producto</li>
                    </ol>
                </div>

                <div class="info-box-gen warning">
                    <h4>⚠️ Importante</h4>
                    <p>El código generado se reserva solo cuando creas el producto. Si no lo usas inmediatamente, podría ser asignado a otro producto.</p>
                </div>
            </div>

            <div class="generador-form">
                <h4>Selecciona la Categoría</h4>
                
                <div class="categorias-select">
                    <div class="categoria-option" onclick="generarCodigo('Vestidos')">
                        <div class="cat-icon" style="background: #ffcdd2;">👗</div>
                        <div class="cat-info">
                            <strong>Vestidos</strong>
                            <small>VB001-VB099</small>
                        </div>
                    </div>

                    <div class="categoria-option" onclick="generarCodigo('Blusas')">
                        <div class="cat-icon" style="background: #f8bbd0;">👚</div>
                        <div class="cat-info">
                            <strong>Blusas</strong>
                            <small>VB100-VB199</small>
                        </div>
                    </div>

                    <div class="categoria-option" onclick="generarCodigo('Faldas')">
                        <div class="cat-icon" style="background: #e1bee7;">🎽</div>
                        <div class="cat-info">
                            <strong>Faldas</strong>
                            <small>VB200-VB299</small>
                        </div>
                    </div>

                    <div class="categoria-option" onclick="generarCodigo('Pantalones')">
                        <div class="cat-icon" style="background: #c5cae9;">👖</div>
                        <div class="cat-info">
                            <strong>Pantalones</strong>
                            <small>VB300-VB399</small>
                        </div>
                    </div>

                    <div class="categoria-option" onclick="generarCodigo('Chaquetas')">
                        <div class="cat-icon" style="background: #bbdefb;">🧥</div>
                        <div class="cat-info">
                            <strong>Chaquetas</strong>
                            <small>VB400-VB499</small>
                        </div>
                    </div>

                    <div class="categoria-option" onclick="generarCodigo('Accesorios')">
                        <div class="cat-icon" style="background: #b2ebf2;">💍</div>
                        <div class="cat-info">
                            <strong>Accesorios</strong>
                            <small>VB500-VB599</small>
                        </div>
                    </div>

                    <div class="categoria-option" onclick="generarCodigo('Zapatos')">
                        <div class="cat-icon" style="background: #b2dfdb;">👠</div>
                        <div class="cat-info">
                            <strong>Zapatos</strong>
                            <small>VB600-VB699</small>
                        </div>
                    </div>

                    <div class="categoria-option" onclick="generarCodigo('Carteras')">
                        <div class="cat-icon" style="background: #c8e6c9;">👜</div>
                        <div class="cat-info">
                            <strong>Carteras</strong>
                            <small>VB700-VB799</small>
                        </div>
                    </div>
                </div>

                <div id="resultado-generacion" class="resultado-box" style="display: none;">
                    <div class="resultado-header">
                        <h4>✅ Código Generado</h4>
                    </div>
                    <div class="codigo-generado-box">
                        <div class="codigo-grande" id="codigo-resultado">VB001</div>
                        <button onclick="copiarCodigo()" class="btn-copiar">
                            📋 Copiar Código
                        </button>
                    </div>
                    <div class="resultado-info">
                        <p><strong>Categoría:</strong> <span id="categoria-resultado"></span></p>
                        <p><small>Este es el siguiente código disponible en el rango</small></p>
                    </div>
                    <div class="resultado-acciones">
                        <a href="<?php echo BASE_URL; ?>producto/create" class="btn btn-primary">
                            ➕ Crear Producto con este Código
                        </a>
                        <button onclick="generarOtro()" class="btn btn-secondary">
                            🔄 Generar Otro
                        </button>
                    </div>
                </div>

                <div id="loading" class="loading-box" style="display: none;">
                    <div class="spinner"></div>
                    <p>Generando código...</p>
                </div>

                <div id="error-generacion" class="error-box" style="display: none;"></div>
            </div>
        </div>
    </div>
</div>

<style>
.generador-container {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 30px;
    margin-top: 20px;
}

.generador-info {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.info-box-gen {
    background: #f9f9f9;
    padding: 20px;
    border-radius: 10px;
    border-left: 4px solid #F9C8C3;
}

.info-box-gen.warning {
    background: #fff9c4;
    border-left-color: #f57f17;
}

.info-box-gen h4 {
    margin-bottom: 15px;
    color: #333;
}

.info-box-gen ol {
    margin-left: 20px;
    color: #666;
    line-height: 1.8;
}

.info-box-gen p {
    color: #666;
    line-height: 1.6;
}

.generador-form h4 {
    margin-bottom: 20px;
    color: #333;
}

.categorias-select {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    margin-bottom: 20px;
}

.categoria-option {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: white;
    border: 2px solid #f0f0f0;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.categoria-option:hover {
    border-color: #F9C8C3;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(249, 200, 195, 0.3);
}

.cat-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    flex-shrink: 0;
}

.cat-info {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.cat-info strong {
    color: #333;
    font-size: 16px;
}

.cat-info small {
    color: #999;
    font-size: 12px;
}

.resultado-box {
    background: linear-gradient(135deg, #c8e6c9 0%, #a5d6a7 100%);
    padding: 30px;
    border-radius: 15px;
    text-align: center;
    animation: slideIn 0.5s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.resultado-header h4 {
    color: #2e7d32;
    margin-bottom: 20px;
}

.codigo-generado-box {
    background: white;
    padding: 30px;
    border-radius: 10px;
    margin-bottom: 20px;
}

.codigo-grande {
    font-size: 48px;
    font-weight: 700;
    color: #F9C8C3;
    font-family: monospace;
    margin-bottom: 15px;
    letter-spacing: 3px;
}

.btn-copiar {
    background: #F9C8C3;
    color: #333;
    border: none;
    padding: 12px 30px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    font-family: 'Poppins', sans-serif;
}

.btn-copiar:hover {
    background: #f7b5ae;
    transform: translateY(-2px);
}

.resultado-info {
    background: rgba(255, 255, 255, 0.5);
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.resultado-info p {
    margin: 5px 0;
    color: #2e7d32;
}

.resultado-acciones {
    display: flex;
    gap: 10px;
    justify-content: center;
    flex-wrap: wrap;
}

.loading-box {
    text-align: center;
    padding: 40px;
}

.spinner {
    width: 50px;
    height: 50px;
    border: 5px solid #f3f3f3;
    border-top: 5px solid #F9C8C3;
    border-radius: 50%;
    margin: 0 auto 20px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.error-box {
    background: #ffcdd2;
    color: #c62828;
    padding: 20px;
    border-radius: 10px;
    border-left: 4px solid #c62828;
}

@media (max-width: 968px) {
    .generador-container {
        grid-template-columns: 1fr;
    }
    
    .categorias-select {
        grid-template-columns: 1fr;
    }
    
    .codigo-grande {
        font-size: 36px;
    }
}
</style>

<script>
let codigoGenerado = '';

function generarCodigo(categoria) {
    document.getElementById('resultado-generacion').style.display = 'none';
    document.getElementById('error-generacion').style.display = 'none';
    document.getElementById('loading').style.display = 'block';
    
    fetch('<?php echo BASE_URL; ?>codigos/generar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'categoria=' + encodeURIComponent(categoria)
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('loading').style.display = 'none';
        
        if (data.error) {
            document.getElementById('error-generacion').textContent = '❌ ' + data.error;
            document.getElementById('error-generacion').style.display = 'block';
            return;
        }
        
        if (data.success) {
            codigoGenerado = data.codigo;
            document.getElementById('codigo-resultado').textContent = data.codigo;
            document.getElementById('categoria-resultado').textContent = data.categoria;
            document.getElementById('resultado-generacion').style.display = 'block';
        }
    })
    .catch(error => {
        document.getElementById('loading').style.display = 'none';
        document.getElementById('error-generacion').textContent = '❌ Error al generar el código';
        document.getElementById('error-generacion').style.display = 'block';
        console.error(error);
    });
}

function copiarCodigo() {
    const codigo = document.getElementById('codigo-resultado').textContent;
    
    navigator.clipboard.writeText(codigo).then(() => {
        const btn = document.querySelector('.btn-copiar');
        const textoOriginal = btn.textContent;
        btn.textContent = '✅ ¡Copiado!';
        btn.style.background = '#c8e6c9';
        
        setTimeout(() => {
            btn.textContent = textoOriginal;
            btn.style.background = '#F9C8C3';
        }, 2000);
    }).catch(err => {
        alert('Error al copiar: ' + err);
    });
}

function generarOtro() {
    document.getElementById('resultado-generacion').style.display = 'none';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>